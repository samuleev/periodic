<?php echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<OAI-PMH xmlns="http://www.openarchives.org/OAI/2.0/"
         xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/
		http://www.openarchives.org/OAI/2.0/OAI-PMH.xsd">
    <responseDate>{{{$responseDate}}}</responseDate>
    <request verb="ListSets">{{{$baseUrl}}}</request>
    <ListSets>
        <set>
            <setSpec>{!!$defaultSetSpec!!}</setSpec>
            <setName>Default set</setName>
            <setDescription>
                <oai_dc:dc
                        xmlns:oai_dc="http://www.openarchives.org/OAI/2.0/oai_dc/"
                        xmlns:dc="http://purl.org/dc/elements/1.1/"
                        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                        xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/oai_dc/
						http://www.openarchives.org/OAI/2.0/oai_dc.xsd">
                    <dc:description></dc:description>
                </oai_dc:dc>
            </setDescription>
        </set>
    </ListSets>
</OAI-PMH>
