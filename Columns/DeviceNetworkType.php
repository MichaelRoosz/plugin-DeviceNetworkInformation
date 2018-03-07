<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\DeviceNetworkInformation\Columns;

use Piwik\Common;
use Piwik\Tracker\Request;
use Piwik\Tracker\Visitor;
use Piwik\Tracker\Action;
use Piwik\Plugin\Dimension\VisitDimension;

class DeviceNetworkType extends VisitDimension
{
    protected $columnName = 'config_device_networktype';
    protected $columnType = 'VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL';
    protected $type = self::TYPE_TEXT;
    protected $nameSingular = 'DevicesDetection_DeviceNetworkType';
    protected $namePlural = 'DevicesDetection_DeviceNetworkTypes';
    protected $segmentName = 'deviceNetworkType';
    protected $acceptValues = 'bluetooth, cellular, ethernet, none, wifi, wimax, other, unknown';

    protected static $validNetworkTypes = array(
        'bluetooth' => true,
        'cellular' => true,
        'ethernet' => true,
        'none' => true,
        'wifi' => true,
        'wimax' => true,
        'other' => true,
        'unknown' => true
    );

    /**
     * @param Request $request
     * @param Visitor $visitor
     * @param Action|null $action
     * @return mixed
     */
    public function onNewVisit(Request $request, Visitor $visitor, $action)
    {
        $networkType = strtolower(Common::getRequestVar('networktype', 'unknown', 'string', $request->getParams()));
        
        if (!isset(self::$validNetworkTypes[$networkType])) {
            $networkType = 'unknown';
        }
        
        return $networkType;
    }

    /**
     * @param Request $request
     * @param Visitor $visitor
     * @param Action|null $action
     * @return mixed
     */
    public function onAnyGoalConversion(Request $request, Visitor $visitor, $action)
    {
        return $visitor->getVisitorColumn($this->columnName);
    }
}
