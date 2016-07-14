<?php

namespace App\Http\Controllers;

use App\Dao\AlternativeDao;
use App\Dao\ArticleDao;
use App\Dao\DaoUtil;
use App\Referat\ReferatParser;
use App\Service\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;
use App\Exceptions\NoElementException;

class OaiController extends Controller {

    const PAGE_SIZE = 100;
    const METADATA_PREFIX_DC = 'oai_dc';
    const MIN_FROM = '2000-00-00 00:00:00';
    const MAX_UNTIL = '2222-00-00 00:00:00';

    private static $RECORDS_ARGUMENTS = array('verb', 'from', 'until', 'metadataprefix', 'set', 'resumptiontoken');

    const ERROR_BAD_ARGUMENT = 0;
    const ERROR_BAD_RESUMPTION_TOKEN = 1;
    const ERROR_NO_RECORDS_MATCH = 3;
    const ERROR_NO_SET_HIERARCHY = 4;
    const ERROR_ID_DOES_NOT_EXIST = 5;

    private static $ERROR_CODES = array(
        self::ERROR_BAD_ARGUMENT => 'badArgument',
        self::ERROR_BAD_RESUMPTION_TOKEN => 'badResumptionToken',
        2 => 'cannotDisseminateFormat',
        self::ERROR_NO_RECORDS_MATCH => 'noRecordsMatch',
        self::ERROR_NO_SET_HIERARCHY => 'noSetHierarchy',
        self::ERROR_ID_DOES_NOT_EXIST => 'idDoesNotExist');

    private $isPost = false;

    public function main(Request $request) {
        $verb = self::getQueryValue($request, 'verb');

        switch ($verb) {
            case 'Identify': return self::identify($request);
            case 'ListRecords': return self::listRecords($request);
            case 'ListMetadataFormats': return self::listMetadataFormats($request);
            case 'ListIdentifiers': return self::listIdentifiers($request);
            case 'ListSets': return self::listSets($request);
            case 'GetRecord': return self::getRecord($request);
            default: return self::getErrorPage($request, 'badVerb', 'Unknown verb');
        }
    }


    private function getRecord(Request $request) {
        try {
            $query = self::getQueryValues($request);

            if (!array_key_exists('identifier', $query)
                || !array_key_exists('metadataprefix', $query)) {
                throw new OaiError('not enough parameters"', self::ERROR_BAD_ARGUMENT);
            }

            if ($query['metadataprefix'] != self::getCommonValues($request)['metadataPrefix']) {
                throw new OaiError("Incorrect metadataPrefix parameter", self::ERROR_BAD_ARGUMENT);
            }


            $articleId = self::getArticleId($query['identifier'], $request);
            $articles = ArticleDao::findContentById($articleId);
            $articles = ArticleService::getEnrichedArticles($articles);
            $article = DaoUtil::returnSingleElement($articles);
            self::enrichArticle($article);

            $values = self::getCommonValues($request);
            $values['article'] = $article;

            return Response::view('oai.record', $values)
                ->header('Content-Type', 'application/xml');

        }  catch (OaiError $e) {
            return self::getErrorPage($request, self::$ERROR_CODES[$e->getCode()], $e->getMessage());
        }
    }


    private function getErrorPage($request, $errorCode, $errorMessage) {
        $values = self::getCommonValues($request);
        $values['errorCode'] = $errorCode;
        $values['errorMessage'] = $errorMessage;

        return Response::view('oai.error', $values)
            ->header('Content-Type', 'application/xml');
    }

    private function checkRecordsArguments($request) {
        $query = self::getQueryValues($request);

        if (array_key_exists('resumptiontoken', $query) && array_key_exists('metadataprefix', $query)) {
            throw new OaiError('illegal parameter - "metadataprefix"', self::ERROR_BAD_ARGUMENT);
        }

        foreach($query as $key => $value) {
            if (!in_array($key, self::$RECORDS_ARGUMENTS)) {
                throw new OaiError('illegal parameter - ' . $key, self::ERROR_BAD_ARGUMENT);
            }
        }

        if (array_key_exists('set', $query)
            && $query['set'] != self::getCommonValues($request)['defaultSetSpec']) {
                throw new OaiError('Incorrect set - ' . $query['set'], self::ERROR_NO_SET_HIERARCHY);
        }

        if (array_key_exists('from', $query) && array_key_exists('until', $query)
            && strlen($query['from']) != strlen($query['until'])) {
            throw new OaiError('from granularity != until granularity', self::ERROR_BAD_ARGUMENT);
        }

        foreach(self::$RECORDS_ARGUMENTS as $argument) {
            $parts = explode($argument . '=', strtolower($request->getUri()));
            if (count($parts) > 2) {
                throw new OaiError('Duplicate argument - '. $argument, self::ERROR_BAD_ARGUMENT);
            }
        }

        self::validateDateArgument('from', $query);

        self::validateDateArgument('until', $query);

        return null;
    }

    private function validateDateArgument($key, $query) {
        if (array_key_exists($key, $query) && strlen($query[$key]) < 10) {
            throw new OaiError('Incorrect date format - '. $query[$key], self::ERROR_BAD_ARGUMENT);
        }
    }

    private function getQueryValue(Request $request, $key) {
        $query = self::getQueryValues($request);
        $key = strtolower($key);
        if (!array_key_exists($key, $query)) {
            return null;
        }
        return $query[strtolower ($key)];
    }

    private function getQueryValues(Request $request) {
        if ($this->isPost) {
            parse_str($request->getContent(), $output);
            return array_change_key_case($output, CASE_LOWER);
        }
        return array_change_key_case($request->query->all(), CASE_LOWER);
    }

    public function mainPost(Request $request) {
        $this->isPost = true;

        return self::main($request);
    }

    public function identify(Request $request) {
        if(count(self::getQueryValues($request)) > 1) {
            return self::getErrorPage($request, 'badArgument', 'illegal parameter(s)');
        }

        $values = self::getCommonValues($request);
        return Response::view('oai.identify', $values)
            ->header('Content-Type', 'application/xml');
    }

    public function listMetadataFormats(Request $request) {
        $query = self::getQueryValues($request);

        if (array_key_exists('identifier', $query)) {

            try {
                self::getArticleId($query['identifier'], $request);
            } catch (OaiError $e) {
                return self::getErrorPage($request, self::$ERROR_CODES[$e->getCode()], $e->getMessage());
            }

        }

        $values = self::getCommonValues($request);

        return Response::view('oai.metadata', $values)
            ->header('Content-Type', 'application/xml');
    }

    private function getArticleId($oaiId, $request) {
        $oaiPrefix = self::getCommonValues($request)['id_prefix'];
        if (!self::startsWith($oaiId, $oaiPrefix)) {
            throw new OaiError("Incorrect id prefix", self::ERROR_ID_DOES_NOT_EXIST);
        }

        $articleId = substr($oaiId, strlen($oaiPrefix));
        if (!is_numeric($articleId)) {
            throw new OaiError("Id not numeric", self::ERROR_ID_DOES_NOT_EXIST);
        }

        try {
            ArticleDao::findById($articleId);
        } catch (NoElementException $e) {
            throw new OaiError("Id not found in db", self::ERROR_ID_DOES_NOT_EXIST);
        }

        return $articleId;
    }

    private function startsWith($string, $query) {
        return substr($string, 0, strlen($query)) === $query;
    }

    public function listIdentifiers(Request $request) {
        try {
            $data = self::getArticleValues($request);
            return Response::view('oai.identifiers', $data)
                ->header('Content-Type', 'application/xml');
        } catch (OaiError $e) {
            return self::getErrorPage($request, self::$ERROR_CODES[$e->getCode()], $e->getMessage());
        }
    }

    private function checkMetadataPrefix(Request $request) {
        if (null == self::getQueryValue($request, 'resumptionToken')) {
            $metadataPrefix = self::getQueryValue($request, 'metadataPrefix');
            if (empty($metadataPrefix)) {
                throw new OaiError("Missing metadataPrefix parameter", self::ERROR_BAD_ARGUMENT);
            }

            if ($metadataPrefix != self::METADATA_PREFIX_DC) {
                throw new OaiError("Incorrect metadataPrefix parameter", self::ERROR_BAD_ARGUMENT);
            }
        }
    }

    public function listRecords(Request $request) {
        try {
            $data = self::getArticleValues($request);
            return Response::view('oai.records', $data)
                ->header('Content-Type', 'application/xml');
        } catch (OaiError $e) {
            return self::getErrorPage($request, self::$ERROR_CODES[$e->getCode()], $e->getMessage());
        }
    }

    private function checkToken($token, $completeListSize) {
        if (is_numeric($token) && $token >= 0 && $token <= $completeListSize) {
            return;
        }
        throw new OaiError("Incorrect resumptionToken", self::ERROR_BAD_RESUMPTION_TOKEN);
    }

    private function getArticleValues(Request $request) {
        $values = self::getCommonValues($request);

        self::checkRecordsArguments($request);

        self::checkMetadataPrefix($request);

        $from = self::MIN_FROM;
        $from_temp = self::getQueryValue($request, 'from');
        if ($from_temp != null) {
            $from = $from_temp;
        }

        $until = self::MAX_UNTIL;
        $until_temp = self::getQueryValue($request, 'until');
        if ($until_temp != null) {
            if(strlen($until_temp) == 10) {
            // day granularity
                $until = $until_temp . 'T23:59:59Z';
            } else {
                $until = $until_temp;
            }
        }

        $values['completeListSize'] = ArticleDao::getContentCount($from, $until);
        if ($values['completeListSize'] == 0) {
            throw new OaiError('0 records', self::ERROR_NO_RECORDS_MATCH);
        }

        $resumptionToken = self::getQueryValue($request, 'resumptionToken');

        if ($resumptionToken == null) {
            $resumptionToken = 0;
        }
        self::checkToken($resumptionToken, $values['completeListSize']);

        $articles = ArticleDao::findContentCustomPaginated($resumptionToken, self::PAGE_SIZE, $from, $until);
        $articles = ArticleService::getEnrichedArticles($articles);
        foreach($articles as $article)
        {
            self::enrichArticle($article);
        }
        $values['articles'] = $articles;
        $values['expirationDate'] = self::getDateAsString(time() + 86400 * 2);
        $values['cursor'] = $resumptionToken;

        if ($resumptionToken + self::PAGE_SIZE > $values['completeListSize']) {
            $values['resumptionToken'] = "";
        } else {
            $values['resumptionToken'] = $resumptionToken + self::PAGE_SIZE;
        }

        return $values;
    }

    private function enrichArticle($article) {
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
        $article->updated = date("Y-m-d\\TH:i:s\\Z", strtotime($article->updated));
    }

    private function getBaseUrl(Request $request) {
        return str_replace('?'.$request->getQueryString(), '', $request->getUri());
    }

    private function getCommonValues(Request $request) {
        $values = array(
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
            'baseAppURL' => 'http://www.hups.mil.gov.ua/periodic-app/',
            'defaultSetSpec' => 'DEFAULT'
        );

        $id_prefix = $values['scheme'] . $values['delimiter'] . $values['repositoryIdentifier'] . $values['delimiter'] . 'article/';

        $values['id_prefix'] = $id_prefix;

        return $values;
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
        foreach($alternative->authorNames as $authorIndex => $authorName) {
            $alternative->authorNames[$authorIndex] = trim($authorName);
        }
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