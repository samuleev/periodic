<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<OAI-PMH xmlns="http://www.openarchives.org/OAI/2.0/"
         xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/
		http://www.openarchives.org/OAI/2.0/OAI-PMH.xsd">
    <responseDate>{{{$responseDate}}}</responseDate>
    <request verb="Identify">{{{$baseUrl}}}</request>
    <Identify>
        <repositoryName>{{{$repositoryName}}}</repositoryName>
        <baseURL>{{{$baseUrl}}}</baseURL>
        <protocolVersion>{{{$protocolVersion}}}</protocolVersion>
        <adminEmail>{{{$adminEmail}}}</adminEmail>
        <earliestDatestamp>{{{$earliestDatestamp}}}</earliestDatestamp>
        <deletedRecord>{{{$deletedRecord}}}</deletedRecord>
        <granularity>{{{$granularity}}}</granularity>
        <description>
            <oai-identifier
                xmlns="http://www.openarchives.org/OAI/2.0/oai-identifier"
                xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/oai-identifier
					http://www.openarchives.org/OAI/2.0/oai-identifier.xsd">
                <scheme>{{{$scheme}}}</scheme>
                <repositoryIdentifier>{{{$repositoryIdentifier}}}</repositoryIdentifier>
                <delimiter>{{{$delimiter}}}</delimiter>
                <sampleIdentifier>{{{$scheme . $delimiter . $repositoryIdentifier . $delimiter . 'article/1'}}}</sampleIdentifier>
            </oai-identifier>
        </description>
    </Identify>
</OAI-PMH>
