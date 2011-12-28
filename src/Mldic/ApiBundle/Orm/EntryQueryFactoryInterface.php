<?php
/**
 * @package orm
 */
namespace Mldic\ApiBundle\Orm;

interface EntryQueryFactoryInterface extends QueryFactoryInterface
{
    public function getFindByPhraseQuery($phrase);
    public function getFindByPhraseAndLanguageQuery($phrase, $language);
    public function getFindByPhraseUsingWildcardsQuery($phrase);
    public function getFindSimilarByPhraseQuery($phrase);
    public function getFindByPhraseUsingWildcardsAndLanguageQuery($phrase, $language);
    public function getFindSimilarByPhraseAndLanguageQuery($phrase, $language);
}
