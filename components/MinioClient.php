<?php

namespace app\components;

use Aws\Exception\AwsException;
use Aws\S3\S3Client;

class MinioClient
{
    private S3Client $client;
    private string|array|false $bucket;

    public function __construct()
    {
        $this->client = new S3Client([
            'version' => 'latest',
            'region' => 'us-east-1',
            'endpoint' => getenv('MINIO_ENDPOINT'),
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key' => getenv('MINIO_ACCESS_KEY'),
                'secret' => getenv('MINIO_SECRET_KEY'),
            ],
            'useSSL' => false
        ]);

        $this->bucket = getenv('MINIO_BUCKET');
        $bucketName = 'mybucket';

        try {
            // Проверяем, существует ли бакет
            $buckets =   $this->client->listBuckets();
            $bucketExists = false;
            foreach ($buckets['Buckets'] as $bucket) {
                if ($bucket['Name'] === $bucketName) {
                    $bucketExists = true;
                    break;
                }
            }

            if (!$bucketExists) {
                // Если бакет не существует, создаём его
                $this->client->createBucket([
                    'Bucket' => $bucketName,
                ]);
            }
        } catch (AwsException $e) {
            echo "Ошибка: " . $e->getMessage();
        }
    }

    public function uploadFile($key, $filePath): string
    {
        try {
            $this->client->putObject([
                'Bucket' => $this->bucket,
                'Key' => $key,
                'SourceFile' => $filePath,
            ]);

            return "File uploaded successfully.";
        } catch (\Exception $e) {
            return "Error uploading file: " . $e->getMessage();
        }
    }

    public function getFileUrl($key): string
    {
        return $this->client->getObjectUrl($this->bucket, $key);
    }
}