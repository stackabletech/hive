<?php
namespace metastore;

/**
 * Autogenerated by Thrift Compiler (0.13.0)
 *
 * DO NOT EDIT UNLESS YOU ARE SURE THAT YOU KNOW WHAT YOU ARE DOING
 *  @generated
 */
use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Type\TMessageType;
use Thrift\Exception\TException;
use Thrift\Exception\TProtocolException;
use Thrift\Protocol\TProtocol;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Exception\TApplicationException;

class ThriftHiveMetastore_get_type_all_result
{
    static public $isValidate = false;

    static public $_TSPEC = array(
        0 => array(
            'var' => 'success',
            'isRequired' => false,
            'type' => TType::MAP,
            'ktype' => TType::STRING,
            'vtype' => TType::STRUCT,
            'key' => array(
                'type' => TType::STRING,
            ),
            'val' => array(
                'type' => TType::STRUCT,
                'class' => '\metastore\Type',
                ),
        ),
        1 => array(
            'var' => 'o2',
            'isRequired' => false,
            'type' => TType::STRUCT,
            'class' => '\metastore\MetaException',
        ),
    );

    /**
     * @var array
     */
    public $success = null;
    /**
     * @var \metastore\MetaException
     */
    public $o2 = null;

    public function __construct($vals = null)
    {
        if (is_array($vals)) {
            if (isset($vals['success'])) {
                $this->success = $vals['success'];
            }
            if (isset($vals['o2'])) {
                $this->o2 = $vals['o2'];
            }
        }
    }

    public function getName()
    {
        return 'ThriftHiveMetastore_get_type_all_result';
    }


    public function read($input)
    {
        $xfer = 0;
        $fname = null;
        $ftype = 0;
        $fid = 0;
        $xfer += $input->readStructBegin($fname);
        while (true) {
            $xfer += $input->readFieldBegin($fname, $ftype, $fid);
            if ($ftype == TType::STOP) {
                break;
            }
            switch ($fid) {
                case 0:
                    if ($ftype == TType::MAP) {
                        $this->success = array();
                        $_size1236 = 0;
                        $_ktype1237 = 0;
                        $_vtype1238 = 0;
                        $xfer += $input->readMapBegin($_ktype1237, $_vtype1238, $_size1236);
                        for ($_i1240 = 0; $_i1240 < $_size1236; ++$_i1240) {
                            $key1241 = '';
                            $val1242 = new \metastore\Type();
                            $xfer += $input->readString($key1241);
                            $val1242 = new \metastore\Type();
                            $xfer += $val1242->read($input);
                            $this->success[$key1241] = $val1242;
                        }
                        $xfer += $input->readMapEnd();
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 1:
                    if ($ftype == TType::STRUCT) {
                        $this->o2 = new \metastore\MetaException();
                        $xfer += $this->o2->read($input);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                default:
                    $xfer += $input->skip($ftype);
                    break;
            }
            $xfer += $input->readFieldEnd();
        }
        $xfer += $input->readStructEnd();
        return $xfer;
    }

    public function write($output)
    {
        $xfer = 0;
        $xfer += $output->writeStructBegin('ThriftHiveMetastore_get_type_all_result');
        if ($this->success !== null) {
            if (!is_array($this->success)) {
                throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('success', TType::MAP, 0);
            $output->writeMapBegin(TType::STRING, TType::STRUCT, count($this->success));
            foreach ($this->success as $kiter1243 => $viter1244) {
                $xfer += $output->writeString($kiter1243);
                $xfer += $viter1244->write($output);
            }
            $output->writeMapEnd();
            $xfer += $output->writeFieldEnd();
        }
        if ($this->o2 !== null) {
            $xfer += $output->writeFieldBegin('o2', TType::STRUCT, 1);
            $xfer += $this->o2->write($output);
            $xfer += $output->writeFieldEnd();
        }
        $xfer += $output->writeFieldStop();
        $xfer += $output->writeStructEnd();
        return $xfer;
    }
}
