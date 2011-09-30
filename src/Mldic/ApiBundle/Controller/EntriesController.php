<?php
namespace Mldic\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EntriesController extends Controller
{
    public function searchByPhraseAction($phrase = null)
    {
        return $this->get('datamapper.entry')->all(array('phrase' => $phrase));
    }
    
    public function searchByPhraseAndLanguageAction($phrase, $language)
    {
        $entries = $this->get('datamapper.entry')->all(array('phrase' => $phrase,
                                                           'language' => $language));
        if (empty($entries)) {
            throw new NotFoundHttpException('Entry not found!');
        }
        return $entries[0];
    }
}
