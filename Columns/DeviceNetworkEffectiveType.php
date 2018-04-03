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

class DeviceNetworkEffectiveType extends VisitDimension
{
    protected $columnName = 'config_device_nwefftype';
    protected $columnType = 'ENUM(\'slow-2g\', \'2g\', \'3g\', \'4g\', \'unknown\') NULL DEFAULT NULL';
    protected $type = self::TYPE_TEXT;
    protected $nameSingular = 'DeviceNetworkInformation_DeviceNetworkEffectiveType';
    protected $namePlural = 'DeviceNetworkInformation_DeviceNetworkEffectiveTypes';
    protected $segmentName = 'deviceNetworkEffectiveType';
    protected $acceptValues = 'slow-2g, 2g, 3g, 4g, unknown';
    
    protected static $validNetworkEffectiveTypes = array(
        'slow-2g' => true,
        '2g' => true,
        '3g' => true,
        '4g' => true,
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
        $networkEffectiveType = strtolower(Common::getRequestVar('nwefftype', 'unknown', 'string', $request->getParams()));
        
        if (empty($networkEffectiveType) || !isset(self::$validNetworkEffectiveTypes[$networkEffectiveType])) {
            $networkEffectiveType = 'unknown';
        }
        
        return $networkEffectiveType;
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
