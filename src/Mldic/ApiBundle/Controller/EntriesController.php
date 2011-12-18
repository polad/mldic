<?php
namespace Mldic\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EntriesController extends Controller
{
    public function findByPhraseAction($phrase = null)
    {
        return $this->get('datamapper.entry')->findByPhrase($phrase);
    }
    
    public function findByPhraseAndLanguageAction($phrase, $language)
    {
        $entry = $this->get('datamapper.entry')->findByPhraseAndLanguage($phrase, $language);
        if (empty($entry)) {
            throw new NotFoundHttpException('Entry not found!');
        }
        return $entry;
    }
}
