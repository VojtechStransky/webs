<?php

declare(strict_types=1);

namespace App\Components\PdfGallery;

use Fykosak\Utils\BaseComponent\BaseComponent;
use Nette\Caching\Cache;
use Nette\Caching\Storage;
use Nette\DI\Container;
use Nette\Utils\Finder;

class PdfGalleryControl extends BaseComponent
{
    private string $wwwDir;
    private Cache $cache;

    public function injectStorage(Storage $storage)
    {
        $this->cache = new Cache($storage, 'App\Components\PdfGallery');
    }

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->wwwDir = $container->getParameters()['wwwDir'];
    }
// TODO typy!!!!!
    public static function getPdfs($path, $wwwDir): array
    {
        $pdfs = [];
        $iterator = null;

        try {
            $iterator = Finder::findFiles('*.pdf')->in($wwwDir . $path)->getIterator();
        } catch (\Exception $e) {
            return [];
        }

        foreach ($iterator as $file) {
            $wwwPath = substr($file->getPathname(), strlen($wwwDir));
            $pdfs[] = [
                'src' => $wwwPath,
                'name' => $file->getBasename(".pdf"),
            ];
        }

        //sort alphabetically
        usort($pdfs, function ($a, $b) {
            return $a['name'] <=> $b['name'];
        });

        foreach ($pdfs as $index => &$pdffile) {
            $pdffile['index'] = $index;
        }
        return $pdfs;
    }

    /**
     * @throws \Nette\Utils\UnknownImageFileException
     */
    public function render(string $path): void
    {
        $this->template->pdfs = $this->cache->load(
            [$path, $this->wwwDir],
            fn() => self::getPdfs($path, $this->wwwDir)
        );
        $this->template->lang = $this->getPresenter()->lang;
        $this->template->render(__DIR__ . DIRECTORY_SEPARATOR . 'pdfGallery.latte');
    }
}
