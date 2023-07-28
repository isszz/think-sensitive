<?php
declare(strict_types=1);

namespace isszz\sensitive;

class Service extends \think\Service
{
    public function boot()
    {
        // 首次运行复制词库
        if (!is_file($file = root_path('config') .'sensitive'. DIRECTORY_SEPARATOR . 'SensitiveWord.txt')) {

            if ((!is_dir($path = dirname($file)))) {
                mkdir($path, 0777, true);
            }

            $sensitiveWordFile = __DIR__ . DIRECTORY_SEPARATOR .'config/SensitiveWord.txt';

            if (!copy($sensitiveWordFile, $file)) {
                throw new SensitiveException('Failed to copy thesaurus. Please manually copy "'. $sensitiveWordFile .'" to "'. $file .'" manually.', 5);
            }
        }

        $this->app->bind('isszz.sensitive', function() {
        	return new Sensitive;
        });
    }
}
