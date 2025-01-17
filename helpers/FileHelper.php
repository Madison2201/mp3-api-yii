<?php

namespace app\helpers;

use app\components\MinioClient;
use Exception;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Audio\Mp3;
use Yii;

class FileHelper
{
    const string TEMP_PATH = '@runtime/temp';
    const string COMPRESSED_PATH = '@runtime/temp/compressed';

    /**
     * @throws Exception
     */
    public static function upload($file): false|string
    {
        $tempPath = Yii::getAlias(self::TEMP_PATH) . '/' . $file->name ?? time();
        $file->saveAs($tempPath);
        $compressedPath = Yii::getAlias(self::COMPRESSED_PATH) . '/compressed_' . $file->name ?? time();
        (new FileHelper)->compressMp3($tempPath, $compressedPath);
        $compressedData = file_get_contents($compressedPath);
        unlink($tempPath);
        unlink($compressedPath);
        return $compressedData;
    }

    public static function uploadToMinio($file): false|string
    {
        foreach ([self::TEMP_PATH, self::COMPRESSED_PATH] as $path) {
            $alias = Yii::getAlias($path);
            if (!is_dir($alias)) {
                mkdir($alias, 0777, true);
            }
        }
        $tempPath = Yii::getAlias(self::TEMP_PATH) . '/' . $file->name ?? time();
        $file->saveAs($tempPath);
        $compressedPath = Yii::getAlias(self::COMPRESSED_PATH) . '/compressed_' . $file->name ?? time();
        (new FileHelper)->compressMp3($tempPath, $compressedPath);
        $compressedData = file_get_contents($compressedPath);

        $minio = new MinioClient();

        $fileName = $file->name . time() . '.mp3';
        $response = $minio->uploadFile($fileName, $compressedPath);
        $url = $minio->getFileUrl($fileName);
        $urlLocal = 'http://localhost:9005/' . getenv("MINIO_BUCKET") . '/' . $fileName;
        return $urlLocal;
    }

    /**
     * @throws Exception
     */
    private function compressMp3($inputPath, $outputPath): void
    {
        $ffmpeg = FFMpeg::create();
        $audio = $ffmpeg->open($inputPath);

        $format = new Mp3();
        $format->setAudioKiloBitrate(128);
        try {
            $audio->save($format, $outputPath);
        } catch (Exception $exception) {
            throw new Exception("Ошибка сжатия MP3: " . implode("\n", $exception->getMessage()));
        }

    }
}