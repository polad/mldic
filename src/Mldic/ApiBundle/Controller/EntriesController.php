<?php
namespace Mldic\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EntriesController extends Controller
{
    public function findByPhraseAction($phrase)
    {
        $phrase = $this->normalizeString($phrase);
        return $this->get('datamapper.entry')->findByPhrase($phrase);
    }
    
    public function findByPhraseAndLanguageAction($phrase, $language)
    {
        $phrase = $this->normalizeString($phrase);
        return $this->get('datamapper.entry')->findByPhraseAndLanguage($phrase, $language);
    }
    
    public function findUniqueByPhraseAndLanguageAction($phrase, $language)
    {
        $result = $this->findByPhraseAndLanguageAction($phrase, $language);
        if (empty($result)) {
            throw new NotFoundHttpException('Entry not found!');
        }
        return $result[0];
    }
    
    private function normalizeString($value)
    {
        return str_replace('*', '%', $value);
    }
}
