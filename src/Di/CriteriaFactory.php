<?php
    /**
     * PHP7 Phalcon Core Library
     *
     * @author Phoenix <phoenix@twistersfury.com>
     * @license http://www.opensource.org/licenses/mit-license.html MIT License
     * @copyright 2016 Twister's Fury
     */

    namespace TwistersFury\Phalcon\Core\Db;

    use Phalcon\Mvc\Model\Criteria;
    use TwistersFury\Phalcon\Core\Di\FactoryDefault;
    use TwistersFury\Phalcon\Core\Traits\Injectable;

    /**
     * Class CriteriaFactory
     *
     * Helper Class For Constructing Criteria Objects
     *
     * @package TwistersFury\Phalcon\Core\Db
     */
    class CriteriaFactory extends FactoryDefault {
        use Injectable;

        /**
         * Retrieves Base Criteria Using Passed Model For Model
         *
         * @param string $modelName Model Class
         *
         * @return \Phalcon\Mvc\Model\Criteria
         */
        public function getCriteria(string $modelName) : Criteria {
            return $this->getDI()->get('\Phalcon\Mvc\Model\Criteria')
                ->setName($modelName);
        }
    }