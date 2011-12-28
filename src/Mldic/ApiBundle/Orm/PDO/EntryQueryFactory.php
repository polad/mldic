<?php
/**
 * @package orm
 * @subpackage pdo
 */
namespace Mldic\ApiBundle\Orm\PDO;

use Mldic\ApiBundle\Orm\EntryQueryFactoryInterface;

class EntryQueryFactory implements EntryQueryFactoryInterface
{
    public function getFindByIdQuery($id)
    {
        return new Query('SELECT * FROM entries WHERE id=:id',
                         array('id' => $id));
    }
    
    public function getFindByPhraseQuery($phrase)
    {
        return new Query('SELECT * FROM entries ' .
                         'WHERE phrase=:phrase ' .
                         'ORDER BY phrase',
                         array('phrase' => $phrase));
    }
    
    public function getFindByPhraseAndLanguageQuery($phrase, $language)
    {
        return new Query('SELECT e.* FROM entries AS e ' .
                         'INNER JOIN languages AS l ON l.id = e.language_id ' .
                         'WHERE phrase=:phrase AND l.code=:language ' .
                         'ORDER BY phrase',
                         array('phrase' => $phrase, 'language' => $language));
    }
    
    public function getFindByPhraseUsingWildcardsQuery($phrase)
    {
        return new Query('SELECT * FROM entries ' .
                         'WHERE phrase LIKE :phrase ' .
                         'ORDER BY phrase',
                         array('phrase' => $phrase));
    }
    
    public function getFindSimilarByPhraseQuery($phrase)
    {
        return new Query('SELECT * FROM entries ' .
                         'WHERE LEVENSHTEIN(phrase, :phrase)<=3 ' .
                         'ORDER BY LEVENSHTEIN(phrase, :phrase)',
                         array('phrase' => $phrase));
    }
    
    public function getFindByPhraseUsingWildcardsAndLanguageQuery($phrase, $language)
    {
        return new Query('SELECT e.* FROM entries AS e ' .
                         'INNER JOIN languages AS l ON l.id = e.language_id ' .
                         'WHERE phrase LIKE :phrase AND l.code=:language ' .
                         'ORDER BY phrase',
                         array('phrase' => $phrase, 'language' => $language));
    }
    
    public function getFindSimilarByPhraseAndLanguageQuery($phrase, $language)
    {
        return new Query('SELECT e.* FROM entries AS e ' .
                         'INNER JOIN languages AS l ON l.id = e.language_id ' .
                         'WHERE LEVENSHTEIN(phrase, :phrase)<=3 AND l.code=:language ' .
                         'ORDER BY LEVENSHTEIN(phrase, :phrase)',
                         array('phrase' => $phrase, 'language' => $language));
    }
}
