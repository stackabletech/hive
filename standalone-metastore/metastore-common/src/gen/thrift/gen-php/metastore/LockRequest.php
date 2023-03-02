<?php
namespace metastore;

/**
 * Autogenerated by Thrift Compiler (0.16.0)
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

class LockRequest
{
    static public $isValidate = false;

    static public $_TSPEC = array(
        1 => array(
            'var' => 'component',
            'isRequired' => true,
            'type' => TType::LST,
            'etype' => TType::STRUCT,
            'elem' => array(
                'type' => TType::STRUCT,
                'class' => '\metastore\LockComponent',
                ),
        ),
        2 => array(
            'var' => 'txnid',
            'isRequired' => false,
            'type' => TType::I64,
        ),
        3 => array(
            'var' => 'user',
            'isRequired' => true,
            'type' => TType::STRING,
        ),
        4 => array(
            'var' => 'hostname',
            'isRequired' => true,
            'type' => TType::STRING,
        ),
        5 => array(
            'var' => 'agentInfo',
            'isRequired' => false,
            'type' => TType::STRING,
        ),
        6 => array(
            'var' => 'zeroWaitReadEnabled',
            'isRequired' => false,
            'type' => TType::BOOL,
        ),
        7 => array(
            'var' => 'exclusiveCTAS',
            'isRequired' => false,
            'type' => TType::BOOL,
        ),
        8 => array(
            'var' => 'locklessReadsEnabled',
            'isRequired' => false,
            'type' => TType::BOOL,
        ),
    );

    /**
     * @var \metastore\LockComponent[]
     */
    public $component = null;
    /**
     * @var int
     */
    public $txnid = null;
    /**
     * @var string
     */
    public $user = null;
    /**
     * @var string
     */
    public $hostname = null;
    /**
     * @var string
     */
    public $agentInfo = "Unknown";
    /**
     * @var bool
     */
    public $zeroWaitReadEnabled = false;
    /**
     * @var bool
     */
    public $exclusiveCTAS = false;
    /**
     * @var bool
     */
    public $locklessReadsEnabled = false;

    public function __construct($vals = null)
    {
        if (is_array($vals)) {
            if (isset($vals['component'])) {
                $this->component = $vals['component'];
            }
            if (isset($vals['txnid'])) {
                $this->txnid = $vals['txnid'];
            }
            if (isset($vals['user'])) {
                $this->user = $vals['user'];
            }
            if (isset($vals['hostname'])) {
                $this->hostname = $vals['hostname'];
            }
            if (isset($vals['agentInfo'])) {
                $this->agentInfo = $vals['agentInfo'];
            }
            if (isset($vals['zeroWaitReadEnabled'])) {
                $this->zeroWaitReadEnabled = $vals['zeroWaitReadEnabled'];
            }
            if (isset($vals['exclusiveCTAS'])) {
                $this->exclusiveCTAS = $vals['exclusiveCTAS'];
            }
            if (isset($vals['locklessReadsEnabled'])) {
                $this->locklessReadsEnabled = $vals['locklessReadsEnabled'];
            }
        }
    }

    public function getName()
    {
        return 'LockRequest';
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
                case 1:
                    if ($ftype == TType::LST) {
                        $this->component = array();
                        $_size724 = 0;
                        $_etype727 = 0;
                        $xfer += $input->readListBegin($_etype727, $_size724);
                        for ($_i728 = 0; $_i728 < $_size724; ++$_i728) {
                            $elem729 = null;
                            $elem729 = new \metastore\LockComponent();
                            $xfer += $elem729->read($input);
                            $this->component []= $elem729;
                        }
                        $xfer += $input->readListEnd();
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 2:
                    if ($ftype == TType::I64) {
                        $xfer += $input->readI64($this->txnid);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 3:
                    if ($ftype == TType::STRING) {
                        $xfer += $input->readString($this->user);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 4:
                    if ($ftype == TType::STRING) {
                        $xfer += $input->readString($this->hostname);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 5:
                    if ($ftype == TType::STRING) {
                        $xfer += $input->readString($this->agentInfo);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 6:
                    if ($ftype == TType::BOOL) {
                        $xfer += $input->readBool($this->zeroWaitReadEnabled);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 7:
                    if ($ftype == TType::BOOL) {
                        $xfer += $input->readBool($this->exclusiveCTAS);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 8:
                    if ($ftype == TType::BOOL) {
                        $xfer += $input->readBool($this->locklessReadsEnabled);
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
        $xfer += $output->writeStructBegin('LockRequest');
        if ($this->component !== null) {
            if (!is_array($this->component)) {
                throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('component', TType::LST, 1);
            $output->writeListBegin(TType::STRUCT, count($this->component));
            foreach ($this->component as $iter730) {
                $xfer += $iter730->write($output);
            }
            $output->writeListEnd();
            $xfer += $output->writeFieldEnd();
        }
        if ($this->txnid !== null) {
            $xfer += $output->writeFieldBegin('txnid', TType::I64, 2);
            $xfer += $output->writeI64($this->txnid);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->user !== null) {
            $xfer += $output->writeFieldBegin('user', TType::STRING, 3);
            $xfer += $output->writeString($this->user);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->hostname !== null) {
            $xfer += $output->writeFieldBegin('hostname', TType::STRING, 4);
            $xfer += $output->writeString($this->hostname);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->agentInfo !== null) {
            $xfer += $output->writeFieldBegin('agentInfo', TType::STRING, 5);
            $xfer += $output->writeString($this->agentInfo);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->zeroWaitReadEnabled !== null) {
            $xfer += $output->writeFieldBegin('zeroWaitReadEnabled', TType::BOOL, 6);
            $xfer += $output->writeBool($this->zeroWaitReadEnabled);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->exclusiveCTAS !== null) {
            $xfer += $output->writeFieldBegin('exclusiveCTAS', TType::BOOL, 7);
            $xfer += $output->writeBool($this->exclusiveCTAS);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->locklessReadsEnabled !== null) {
            $xfer += $output->writeFieldBegin('locklessReadsEnabled', TType::BOOL, 8);
            $xfer += $output->writeBool($this->locklessReadsEnabled);
            $xfer += $output->writeFieldEnd();
        }
        $xfer += $output->writeFieldStop();
        $xfer += $output->writeStructEnd();
        return $xfer;
    }
}
