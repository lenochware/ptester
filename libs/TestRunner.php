<?php 


class TestRunner
{
    public function run($test)
    {
        $client = new GuzzleHttp\Client(/*['base_uri' => 'http://httpbin.org',  'timeout'  => 2.0,]*/);

        //$res = $client->request('GET', '/status/500', ['http_errors' => false]); bez try catch?

        /*
            $response = $client->send($request, ['timeout' => 2]);
        */

        try {
            $response = $client->request('GET', $test->project->base_url . $test->url);
        } catch (/*GuzzleHttp\Exception\ServerException*/GuzzleHttp\Exception\BadResponseException $exception) {
            $response = $exception->getResponse();
        }

        //$response = $client->request('GET', $test->project->base_url . $test->url);

        $test->body = $this->getContent((string)$response->getBody(), $test);


        if (!$test->getValue('template')) {
            $test->setValue('template', $test->body);
        }

        $test->lastrun_at = date("Y-m-d H:i:s");
        $test->status = $this->passed($test)? 1 : 9;
        $test->save();

        return $test->status;
    }

    public function runAll($tests)
    {
        $startTime = microtime(true);

        $result = ['ok' => 0, 'failed' => 0, 'time' => 0];
        foreach ($tests as $test) {
           $x = $this->run($test);
           if ($x == 1) $result['ok']++; else $result['failed']++;
        }

        $endTime = microtime(true);
        $result['time'] = round($endTime - $startTime,2);

        return $result;
    }

    public function passed($test)
    {
        return $test->template == $test->body;
    }

    // xpath napr. //div[@class="xyz"]
    protected function getContent($html, $test)
    {
        if (!$test->xpath) return $html;

        $content = '';
        libxml_use_internal_errors(true);
        $doc = new DOMDocument();
        @$doc->loadHTML($html);

        $xpath = new DOMXPath($doc);

        if ($test->xpath_exclude) {
            $nodes = $xpath->query($test->xpath_exclude);

            foreach ($nodes as $node) {
                $node->parentNode->removeChild($node);
            }
        }

        $nodes = $xpath->query($test->xpath);

        if ($nodes->length > 0) {
            foreach ($nodes as $node) {
                $content .= $doc->saveHTML($node); // Vrátí celý obsah <div class="xyz">
            }
        }

        return $content;
    }
}