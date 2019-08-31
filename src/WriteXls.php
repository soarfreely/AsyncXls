<?php
/**
 * Desc:
 * User: <soarfreely.z@gmail.com>
 * Date: 19-8-31 Time: 下午3:18
 */

namespace AsyncXls;


use XLSXWriter;

class WriteXls
{
    /**
     * @var XLSXWriter| null
     */
    static $writer = null;

    /**
     * WriteXls constructor.
     */
    private function __construct()
    {
    }

    /**
     * instance
     * User: <soarfreely.z@gmail.com>
     * @return XLSXWriter|null
     * Date: 19-8-31 Time: 下午3:26
     */
    private static function instance()
    {
        if (!self::$writer instanceof XLSXWriter) {
            self::$writer = new XLSXWriter();
        }

        return self::$writer;
    }

    /**
     * write
     * User: <soarfreely.z@gmail.com>
     * @param string $fileName 文件名
     * @param array $headers
     * @param array $data
     * @param array $sheets
     * @param array $options
     * Date: 19-8-31 Time: 下午3:55
     */
    public static function write($fileName, array $data, $sheets = [], array $headers = [], $options = [])
    {
        self::instance();

        $param = [$data, $sheets, $headers, $options];

        if (count($sheets) > 1) {
            self::WriteMultipleSheets(...$param);
        }

        if (count($sheets) == 1) {
            self::writeSingleSheet(...$param);
        }

        self::$writer->writeToFile($fileName);
        self::$writer = null;
    }

    /**
     * writeSingleSheet
     * User: <soarfreely.z@gmail.com>
     * @param array $header
     * @param array $rows
     * @param array $options
     * @param $sheet
     * Date: 19-8-31 Time: 下午4:09
     */
    private static function writeSingleSheet(array $rows, $sheet, array $header, array $options)
    {
        $sheet = $sheet[0] ?: '';
        self::$writer->writeSheetHeader($sheet, $header, $col_options = ['suppress_row'=>true]);

        foreach ($rows as $row) {
            $styles = [];
            self::$writer->writeSheetRow($sheet, $row, $styles);
        }
    }

    /**
     * WriteMultipleSheets
     * User: <soarfreely.z@gmail.com>
     * @param array $data
     * @param array $headers
     * @param array $options
     * @param $sheets
     * Date: 19-8-31 Time: 下午4:09
     */
    private static function WriteMultipleSheets(array $data, $sheets, array $headers, array $options)
    {
        foreach ($data as $index => $rows) {
            $header = $headers[$index] ?:  [];
            $sheet = $sheets[$index] ?: 'sheet' . $index;

            foreach ($rows as $i => $row) {
                $styles = null;
                if (empty($options) && $i == 0) {
                    // 此处仅设置 表头样式，如有需要可自行修改
                    self::handleOptions($row, $options);
                    self::$writer->writeSheetHeader($sheet, $header, $options);
                }
                self::$writer->writeSheetRow($sheet, $row, $options[$i]);
            }
        }
    }

    /**
     * getStyles
     * User: <soarfreely.z@gmail.com>
     * @param $row
     * @param $options
     * Date: 19-8-31 Time: 下午8:17
     */
    private static function handleOptions($row, &$options)
    {
        $options = $options ?: [];
        $columnsNumber = count($row);
        if (!array_key_exists('widths', $options ?: [])) {
            $options['widths'] = array_fill(0, $columnsNumber, 11.5);
        }

        if (!array_key_exists('suppress_row', $options)) {
            $options['suppress_row'] = true;
        }

        if (!array_key_exists('height', $options ?: [])) {
            $options['height'] = 12.1;
        }

        $style = array( 'font'=>'Arial','font-size'=>10,'font-style'=>'bold', 'fill'=>'#63B8FF', 'halign'=>'center', 'border'=>'left,right,top,bottom');

        $options = array_merge($options, $style);
    }
}