<?php

interface NewsClient {
    /**
     * get response
     *
     * @param  array  $options
     * @return array
     */
    public function sendRequest(array $options): array;
}

class NewsApiClient1 implements NewsClient {

    public function sendRequest(array $options): array
    {
        return [
            'data' => 'coming_from_news_api_1' . PHP_EOL
        ];
    }
}

class NewsApiClient2 implements NewsClient {

    public function sendRequest(array $options): array
    {
        return [
            'data' => 'coming_from_news_api_2' . PHP_EOL
        ];
    }
}

class NewsApiClient3 implements NewsClient {

    public function sendRequest(array $options): array
    {
        return [
            'data' => 'coming_from_news_api_3' . PHP_EOL
        ];
    }
}

//---------------------------------------------------//

interface NewsMapper {
    /**
     * map data is coming from out-source
     *
     * @param  array  $data
     * @return array
     */
    public function map(array $data): array;
}

class NewsApiMapper1 implements NewsMapper {

    public function map(array $data): array
    {
        echo $data['data'];
        $data['data'] = 'mapped_by_mapper_1'. PHP_EOL;
        
        return $data;
    }
}

class NewsApiMapper2 implements NewsMapper {

    public function map(array $data): array
    {
        echo $data['data'];
        $data['data'] = 'mapped_by_mapper_2'. PHP_EOL;

        return $data;
    }
}

class NewsApiMapper3 implements NewsMapper {

    public function map(array $data): array
    {
        echo $data['data'];
        $data['data'] = 'mapped_by_mapper_3'. PHP_EOL;

        return $data;
    }
}

//---------------------------------------------------//

interface FetchNewsFactory {
    public function getClient(): NewsClient;

    public function getMapper(): NewsMapper;
}

class FetchNewsApiFactory1 implements FetchNewsFactory {

    public function getClient(): NewsClient
    {
        return new NewsApiClient1;
    }

    public function getMapper(): NewsMapper
    {
        return new NewsApiMapper1;
    }
}

class FetchNewsApiFactory2 implements FetchNewsFactory {

    public function getClient(): NewsClient
    {
        return new NewsApiClient2;
    }

    public function getMapper(): NewsMapper
    {
        return new NewsApiMapper2;
    }
}

class FetchNewsApiFactory3 implements FetchNewsFactory {

    public function getClient(): NewsClient
    {
        return new NewsApiClient3;
    }

    public function getMapper(): NewsMapper
    {
        return new NewsApiMapper3;
    }
}

//---------------------------------------------------//

interface NewsContext {
    public function fetch(): void;
}

class News implements NewsContext {
    public function __construct(private readonly FetchNewsFactory $factory)
    {
    }


    public function fetch(): void
    {
        $client = $this->factory->getClient();
        $mapper = $this->factory->getMapper();

        $data = $client->sendRequest([]);

        $mappedData = $mapper->map($data);

        echo $mappedData['data'];
    }
}

$news1 = new News(new FetchNewsApiFactory1);
$news1->fetch();

$news2 = new News(new FetchNewsApiFactory2);
$news2->fetch();

$news3 = new News(new FetchNewsApiFactory3);
$news3->fetch();