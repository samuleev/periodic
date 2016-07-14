<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<OAI-PMH xmlns="http://www.openarchives.org/OAI/2.0/"
         xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/
		http://www.openarchives.org/OAI/2.0/OAI-PMH.xsd">
    <responseDate>{!!$responseDate!!}</responseDate>
    <request verb="ListRecords" metadataPrefix="{!!$metadataPrefix!!}">{!!$baseUrl!!}</request>
    <ListRecords>
        @foreach($articles as $article)
            @include('oai.record-template')
        @endforeach
        <resumptionToken expirationDate="{!!$expirationDate!!}"
                         completeListSize="{!!$completeListSize!!}"
                         cursor="{!!$cursor!!}">{!!$resumptionToken!!}</resumptionToken>
    </ListRecords>
</OAI-PMH>