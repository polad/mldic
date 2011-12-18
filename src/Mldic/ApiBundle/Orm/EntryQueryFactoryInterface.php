<?php
/**
 * @package orm
 */
namespace Mldic\ApiBundle\Orm;

interface EntryQueryFactoryInterface extends QueryFactoryInterface
{
    public function getFindByPhraseQuery($phrase);
    public function getFindByPhraseAndLanguageQuery($phrase, $language);
}
