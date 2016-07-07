<?php

namespace App\Http\Controllers;

use App\Dao\AlternativeDao;
use App\Dao\ArticleDao;
use App\Referat\ReferatParser;
use App\Service\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;

class OaiController extends Controller {

    const PAGE_SIZE = 100;
    const METADATA_PREFIX_DC = 'oai_dc';

    public function main(Request $request) {
        $verb = $request->input('verb');

        switch ($verb) {
            case 'Identify': return self::identify($request);
            case 'ListRecords': return self::listRecords($request);
            case 'ListMetadataFormats': return self::listMetadataFormats($request);
            case 'ListIdentifiers': return self::listIdentifiers($request);
            case 'ListSets': return self::listSets($request);
            default: App::abort(404, 'Verb not found');
        }
    }

    public function identify(Request $request) {
        $values = self::getCommonValues($request);
        return Response::view('oai.identify', $values)
            ->header('Content-Type', 'application/xml');
    }

    public function listMetadataFormats(Request $request) {
        $values = self::getCommonValues($request);
        return Response::view('oai.metadata', $values)
            ->header('Content-Type', 'application/xml');
    }

    public function listIdentifiers(Request $request) {
        $values = self::getCommonValues($request);
        self::checkMetadataPrefix($request);

        $articles = ArticleDao::findContentIdentifiers();
        $values['articles'] = $articles;

        return Response::view('oai.identifiers', $values)
            ->header('Content-Type', 'application/xml');
    }

    private function checkMetadataPrefix(Request $request) {
        $metadataPrefix = $request->input('metadataPrefix');
        if(empty($metadataPrefix)) {
            throw new \Exception("Missing metadataPrefix parameter");
        }

        if($metadataPrefix != self::METADATA_PREFIX_DC) {
            throw new \Exception("Incorrect metadataPrefix parameter");
        }
    }

    public function listRecords(Request $request) {
        $values = self::getCommonValues($request);

        self::checkMetadataPrefix($request);

        $resumptionToken = $request->input('resumptionToken');

        if ($resumptionToken == null) {
            $resumptionToken = 0;
        }

        $articles = ArticleDao::findContentCustomPaginated($resumptionToken, self::PAGE_SIZE);
        $articles = ArticleService::getEnrichedArticles($articles);
        foreach($articles as $article)
        {
            $alternatives = AlternativeDao::findByArticleId($article->article_id);
            $article->alternatives = $alternatives;

            self::setShortLanguage($article);
            self::assignMainAuthorNames($article);
            self::convertArticleUpdateDate($article);

            $article->fileName = ArticleService::getArticleFileName($article->journal_prefix, $article->edition_issue_year,
                $article->edition_number_in_year, $article->sort_order);


            foreach ($article->alternatives as $alternative) {
                self::setShortLanguage($alternative);
                self::assignAlternativeAuthorNames($alternative, $alternative->authors);

                self::xmlEscape($alternative);
            }

            self::xmlEscape($article);
        }
        $values['articles'] = $articles;
        $values['expirationDate'] = self::getDateAsString(time() + 86400);
        $values['completeListSize'] = ArticleDao::getContentCount();
        $values['cursor'] = $resumptionToken;
        $values['resumptionToken'] = $resumptionToken + self::PAGE_SIZE;

        return Response::view('oai.records', $values)
            ->header('Content-Type', 'application/xml');
    }

    private function xmlEscape($array) {
        foreach ($array as $key => $element) {
            if (is_string ($element)) {
                $array->$key = htmlspecialchars($element, ENT_XML1, 'UTF-8');
                // $array->$key = html_entity_decode($element, ENT_QUOTES, 'UTF-8');
            }
        }
    }

    public function listSets(Request $request) {
        $values = self::getCommonValues($request);
        return Response::view('oai.sets', $values)
            ->header('Content-Type', 'application/xml');
    }

    private function getResponseDate() {
        return self::getDateAsString(time());
    }

    private function getDateAsString($dateAsSeconds) {
        return date("Y-m-d\\Th:i:s\\Z", $dateAsSeconds);
    }

    private function convertArticleUpdateDate($article) {
        $article->updated = date("Y-m-d\\Th:i:s\\Z", strtotime($article->updated));
    }

    private function getBaseUrl(Request $request) {
        return str_replace('?'.$request->getQueryString(), '', $request->getUri());
    }

    private function getCommonValues(Request $request) {
        return array(
            'repositoryName' => 'Наукові видання Харківського університету Повітряних Сил',
            'responseDate' => self::getResponseDate(),
            'baseUrl' => self::getBaseUrl($request),
            'scheme' => 'oai',
            'repositoryIdentifier' => 'periodic.hups.mil.gov.ua',
            'delimiter' => ':',
            'protocolVersion' => '2.0',
            'adminEmail' => 'journal.hups@gmail.com',
            'earliestDatestamp' => '2012-01-12T03:30:58Z',
            'deletedRecord' => 'persistent',
            'granularity' => 'YYYY-MM-DDThh:mm:ssZ',
            'metadataPrefix' => 'oai_dc',
            'baseAppURL' => 'http://www.hups.mil.gov.ua/periodic-app/'
        );
    }

    private function assignMainAuthorNames($article) {
        if ($article->language == ReferatParser::ENG_LANG) {
            self::assignAlternativeAuthorNames($article, $article->authorNamesLine);
            return;
        }

        $authorNames = array();
        foreach($article->authors as $authorIndex => $author) {
            $authorName = '';
            if (isset($author->name)) {
                $authorName = $author->name . '.' ;
                if (isset($author->patronymic)) {
                    $authorName = $authorName . $author->patronymic . '. ' ;
                }
            }

            $authorName = $authorName . $author->surname;
            $authorNames[] = $authorName;
        }
        $article->authorNames = $authorNames;
    }

    private function assignAlternativeAuthorNames($alternative, $authorNamesLine) {
        $alternative->authorNames = explode(",", $authorNamesLine);
    }

    private function setShortLanguage($languageProvider) {
        switch ($languageProvider->language) {
            case ReferatParser::UKR_LANG:
                $languageProvider->language_short = 'uk-UA';
                return;

            case ReferatParser::RUS_LANG:
                $languageProvider->language_short = 'ru-RU';
                return;

            case ReferatParser::ENG_LANG:
                $languageProvider->language_short = 'en-US';
                return;

            default:
                App::abort(404, 'Unknown Language');
        }
    }

}