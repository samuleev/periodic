<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<OAI-PMH xmlns="http://www.openarchives.org/OAI/2.0/"
         xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/
		http://www.openarchives.org/OAI/2.0/OAI-PMH.xsd">
    <responseDate>{{{$responseDate}}}</responseDate>
    <request verb="ListIdentifiers" metadataPrefix="{!!$metadataPrefix!!}">{{{$baseUrl}}}</request>
    <ListIdentifiers>
        @foreach($articles as $article)
        <header>
            <identifier>{!!$scheme . $delimiter . $repositoryIdentifier . $delimiter . 'article/'. $article->article_id!!}</identifier>
            <datestamp>{!!$article->edition_issue_year!!}</datestamp>
        </header>
        @endforeach
    </ListIdentifiers>
</OAI-PMH>
