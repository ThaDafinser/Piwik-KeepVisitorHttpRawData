<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\KeepVisitorHttpRawData\Columns;

use Piwik\Plugin\Dimension\VisitDimension;
use Piwik\Tracker\Request;
use Piwik\Tracker\Visitor;

class KeepVisitorHttpRawData extends VisitDimension
{

    protected $columnName = 'visitor_header_raw';

    protected $columnType = 'LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL';

    public function getName()
    {
        return Piwik::translate('KeepVisitorHttpRawData_VisitorHeaderRaw');
    }

    /**
     * Serialize all HTTP headers
     *
     * @param Request $request            
     * @param Visitor $visitor            
     * @param Action|null $action            
     *
     * @return string
     */
    public function onNewVisit(Request $request, Visitor $visitor, $action)
    {
        $headers = [];
        
        foreach ($_SERVER as $key => $value) {
            
            // skip all none HTTP_* headers!
            if (substr($key, 0, 5) !== 'HTTP_') {
                continue;
            }
            
            $headers[$key] = $value;
        }
        
        return serialize($headers);
    }
}
