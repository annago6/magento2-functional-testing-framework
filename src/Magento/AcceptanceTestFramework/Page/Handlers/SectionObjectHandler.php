<?php

namespace Magento\AcceptanceTestFramework\Page\Handlers;

use Magento\AcceptanceTestFramework\ObjectManager\ObjectHandlerInterface;
use Magento\AcceptanceTestFramework\ObjectManagerFactory;
use Magento\AcceptanceTestFramework\Page\Objects\ElementObject;
use Magento\AcceptanceTestFramework\Page\Objects\SectionObject;
use Magento\AcceptanceTestFramework\XmlParser\SectionParser;

class SectionObjectHandler implements ObjectHandlerInterface
{
    /**
     * Singleton variable instance of class
     * @var SectionObjectHandler $SECTION_DATA_PROCESSOR
     */
    private static $SECTION_DATA_PROCESSOR;

    /**
     * Array containing all Section Objects
     * @var array $sectionData
     */
    private $sectionData = [];

    const TYPE = 'section';
    const SUB_TYPE = 'element';
    const ELEMENT_TYPE_ATTR = 'type';
    const ELEMENT_LOCATOR_ATTR = 'locator';
    const ELEMENT_TIMEOUT_ATTR = 'timeout';

    /**
     * Singleton method to return SectionArrayProcesor.
     * @return SectionObjectHandler
     */
    public static function getInstance()
    {
        if (! self::$SECTION_DATA_PROCESSOR) {
            self::$SECTION_DATA_PROCESSOR = new SectionObjectHandler();
            self::$SECTION_DATA_PROCESSOR->initSectionObjects();
        }

        return self::$SECTION_DATA_PROCESSOR;
    }

    /**
     * SectionObjectHandler constructor.
     * @constructor
     */
    private function __construct()
    {
        // private constructor
    }

    /**
     * Returns the corresponding section array parsed from xml.
     * @param string $sectionName
     * @return SectionObject | null
     */
    public function getObject($sectionName)
    {
        if (array_key_exists($sectionName, $this->getAllObjects())) {
            return $this->getAllObjects()[$sectionName];
        }

        return null;
    }

    /**
     * Returns all section arrays parsed from section xml.
     * @return array
     */
    public function getAllObjects()
    {
        return $this->sectionData;
    }

    /**
     * Parse section objects if it's not previously done.
     * @return void
     */
    private function initSectionObjects()
    {
        $objectManager = ObjectManagerFactory::getObjectManager();
        /** @var $parser \Magento\AcceptanceTestFramework\XmlParser\SectionParser */
        $parser = $objectManager->get(SectionParser::class);
        foreach ($parser->getData(self::TYPE) as $sectionName => $sectionData) {
            // create elements
            $elements = [];
            foreach ($sectionData[SectionObjectHandler::SUB_TYPE] as $elementName => $elementData) {
                $elementType = $elementData[SectionObjectHandler::ELEMENT_TYPE_ATTR];
                $elementLocator = $elementData[SectionObjectHandler::ELEMENT_LOCATOR_ATTR];
                $elementTimeout = $elementData[SectionObjectHandler::ELEMENT_TIMEOUT_ATTR] ?? null;

                $elements[$elementName] = new ElementObject(
                    $elementName,
                    $elementType,
                    $elementLocator,
                    $elementTimeout
                );
            }

            $this->sectionData[$sectionName] = new SectionObject($sectionName, $elements);
        }
    }
}