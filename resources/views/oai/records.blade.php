<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<OAI-PMH xmlns="http://www.openarchives.org/OAI/2.0/"
         xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/
		http://www.openarchives.org/OAI/2.0/OAI-PMH.xsd">
    <responseDate>{!!$responseDate!!}</responseDate>
    <request verb="ListRecords" metadataPrefix="{!!$metadataPrefix!!}">{!!$baseUrl!!}</request>
    <ListRecords>
        @foreach($articles as $article)
        <record>
            <header>
                <identifier>{!!$scheme . $delimiter . $repositoryIdentifier . $delimiter . 'article/'. $article->article_id!!}</identifier>
                <datestamp>{!!$article->updated!!}</datestamp>
            </header>
            <metadata>
                <oai_dc:dc
                        xmlns:oai_dc="http://www.openarchives.org/OAI/2.0/oai_dc/"
                        xmlns:dc="http://purl.org/dc/elements/1.1/"
                        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                        xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/oai_dc/
	                        http://www.openarchives.org/OAI/2.0/oai_dc.xsd">
                    <dc:title xml:lang="{!!$article->language_short!!}">{!!$article->name!!}</dc:title>
                    @foreach($article->alternatives as $alternative)
                        <dc:title xml:lang="{!!$alternative->language!!}">{!!$alternative->name!!}</dc:title>
                    @endforeach

                    @foreach($article->authorNames as $authorName)
                        <dc:creator xml:lang="{!!$article->language_short!!}">{!!$authorName!!}</dc:creator>
                    @endforeach

                    @foreach($article->alternatives as $alternative)
                        @foreach($alternative->authorNames as $authorName)
                            <dc:creator xml:lang="{!!$alternative->language!!}">{!!$authorName!!}</dc:creator>
                        @endforeach
                    @endforeach

                    <dc:subject xml:lang="uk-UA">{!!$article->topic->name!!}</dc:subject>
                    <dc:subject xml:lang="uk-UA">УДК {!!$article->udk!!}</dc:subject>

                    @if(!empty($article->keywords))
                        <dc:subject xml:lang="{!!$article->language_short!!}">{!!$article->keywords!!}</dc:subject>
                    @endif

                    @foreach($article->alternatives as $alternative)
                        @if(!empty($alternative->keywords))
                        <dc:subject xml:lang="{!!$alternative->language!!}">{!!$alternative->keywords!!}</dc:subject>
                        @endif
                    @endforeach

                    @if(!empty($article->description))
                        <dc:description xml:lang="{!!$article->language_short!!}">{!!$article->description!!}</dc:description>
                    @endif

                    @foreach($article->alternatives as $alternative)
                        @if(!empty($alternative->description))
                            <dc:description xml:lang="{!!$alternative->language!!}">{!!$alternative->description!!}</dc:description>
                        @endif
                    @endforeach


                    <dc:publisher xml:lang="uk-UA">Харківський національний університет Повітряних Сил ім. І. Кожедуба</dc:publisher>
                    <dc:publisher xml:lang="ru-RU">Харьковский национальный университет Воздушных Сил им. И. Кожедуба</dc:publisher>
                    <dc:publisher xml:lang="en-US">Kharkiv national Air Force University named after I. Kozhedub</dc:publisher>

                    <dc:date>{!!$article->edition_issue_year!!}</dc:date>
                    <dc:type>info:eu-repo/semantics/article</dc:type>
                    <dc:type>info:eu-repo/semantics/publishedVersion</dc:type>
                    <dc:type>Рецензована стаття</dc:type>

                    <dc:format>application/pdf</dc:format>

                    <dc:identifier>{!!$baseAppURL . 'article/' . $article->article_id!!}</dc:identifier>
                    <dc:source xml:lang="uk-UA">{!!$article->journal_name!!}. — {!!$article->edition_issue_year!!}. — № {!!$article->edition_number_in_year.'('.$article->edition_number.')'!!}. @include('article.pages')</dc:source>
                    <dc:source xml:lang="ru-RU">{!!$article->journal_name_rus!!}. — {!!$article->edition_issue_year!!}. — № {!!$article->edition_number_in_year.'('.$article->edition_number.')'!!}. @include('article.pages')</dc:source>
                    <dc:source xml:lang="en-US">{!!$article->journal_name_eng!!}. — {!!$article->edition_issue_year!!}. — № {!!$article->edition_number_in_year.'('.$article->edition_number.')'!!}. @include('article.pages')</dc:source>
                    <dc:source>{!!$article->journal_issn!!}</dc:source>
                    <dc:language>{!!$article->language!!}</dc:language>
                    <dc:relation>{!!$baseAppURL . 'article/' . $article->article_id . '/' . $article->fileName!!}</dc:relation>

                </oai_dc:dc>
            </metadata>
        </record>
        @endforeach
        <resumptionToken expirationDate="{!!$expirationDate!!}"
                         completeListSize="{!!$completeListSize!!}"
                         cursor="{!!$cursor!!}">{!!$resumptionToken!!}</resumptionToken>
    </ListRecords>
</OAI-PMH>