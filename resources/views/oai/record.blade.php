<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<OAI-PMH xmlns="http://www.openarchives.org/OAI/2.0/"
         xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/
		http://www.openarchives.org/OAI/2.0/OAI-PMH.xsd">
    <responseDate>{!!$responseDate!!}</responseDate>
    <request verb="GetRecord" identifier="{!!$id_prefix . $article->article_id!!}"
             metadataPrefix="{!!$metadataPrefix!!}">{!!$baseUrl!!}</request>
    <GetRecord>
            @include('oai.record-template')
    </GetRecord>
</OAI-PMH>