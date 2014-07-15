
    <?php

    // Unofficial PHP Client for performing Translations using Google Translate. 
    // Not something novel out here. Just a small piece of hack and its done. 

    function getTranslatedDataJSONGoogle($url) {
        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_URL, $url);
        curl_setopt($curlSession, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.114 Safari/537.36");
        $data = curl_exec($curlSession);
        $resultCode = curl_getinfo($curlSession, CURLINFO_HTTP_CODE);
        curl_close($curlSession);

        if ($resultCode == 200) 
            return ($data);
        else 
            return $resultCode;
    }

    function constructRequestURL($japaneseText) {
        $baseURL = "https://translate.google.com/translate_a/single?client=t&sl=auto&tl=en&hl=en&dt=bd&dt=ex&dt=ld&dt=md&dt=qc&dt=rw&dt=rm&dt=ss&dt=t&ie=UTF-8&oe=UTF-8&pc=1&oc=1&otf=1&ssel=0&tsel=0&q=";
        $encodedText = urlencode($japaneseText);
        $requestURL = $baseURL.$encodedText;
        return $requestURL;
    }

    function extractTitleFromResult($jsonString) {
        echo $jsonString."\n"."\n"."\n";
        while(strpos($jsonString, ",,") != FALSE) {
            $jsonString = str_replace(",,", ",null,", $jsonString);
            
        }
        echo $jsonString."\n";

        $result = json_decode($jsonString);
        
        return $result[0][0][0]; // I know right, this is how it is!
    }

    // Example 

        $japaneseWord = "ハローワールド";
        echo "Current word - " . $japaneseWord . "\n";

        $requestURLforJSON = constructRequestURL($japaneseWord);
        $jsonData = getTranslatedDataJSONGoogle($requestURLforJSON);

        $translatedWord = extractTitleFromResult($jsonData);
        echo "Translated Word = $translatedWord \n";

   
