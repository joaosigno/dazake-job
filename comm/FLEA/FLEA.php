<?php
/////////////////////////////////////////////////////////////////////////////
// FleaPHP Framework
//
// Copyright (c) 2005 - 2008 QeeYuan China Inc. (http://www.qeeyuan.com)
//
// ���Э�飬��鿴Դ�����и����� LICENSE.txt �ļ���
// ���߷��� http://www.fleaphp.org/ �����ϸ��Ϣ��
/////////////////////////////////////////////////////////////////////////////

/**
 * ���� FLEA ��ͻ�������������ʼ�� FleaPHP ���л���
 *
 * ���ڴ󲿷� FleaPHP ���������Ҫ��Ԥ�ȳ�ʼ�� FleaPHP ������
 * ��Ӧ�ó�����ֻ��Ҫͨ�� require('FLEA.php') ������ļ���
 * ������� FleaPHP ���л����ĳ�ʼ��������
 *
 * @copyright Copyright (c) 2005 - 2008 QeeYuan China Inc. (http://www.qeeyuan.com)
 * @author ��Դ�Ƽ� (www.qeeyuan.com)
 * @package Core
 * @version $Id: FLEA.php 1525 2008-11-25 08:34:37Z dualface $
 */

/**
 * �����ļ������ʱ��
 */
global $___fleaphp_loaded_time;
$___fleaphp_loaded_time = microtime();

/**
 * ����һЩ���õĳ���
 */

// ���� FleaPHP �汾�ų���
define('FLEA_VERSION', '1.7.1524');

// ����ָʾ PHP4 �� PHP5 �ĳ���
if (substr(PHP_VERSION, 0, 1) == '5') {
    define('PHP5', true);
    define('PHP4', false);
} else {
    define('PHP5', false);
    define('PHP4', true);
}

// ��д�� DIRECTORY_SEPARATOR
define('DS', DIRECTORY_SEPARATOR);

// ��׼ URL ģʽ
define('URL_STANDARD',  'URL_STANDARD');

// PATHINFO ģʽ
define('URL_PATHINFO',  'URL_PATHINFO');

// URL ��дģʽ
define('URL_REWRITE',   'URL_REWRITE');

/**#@+
 * ���� RBAC ������ɫ����
 */
// RBAC_EVERYONE ��ʾ�κ��û������ܸ��û��Ƿ���н�ɫ��Ϣ��
define('RBAC_EVERYONE',     'RBAC_EVERYONE');

// RBAC_HAS_ROLE ��ʾ�����κν�ɫ���û�
define('RBAC_HAS_ROLE',     'RBAC_HAS_ROLE');

// RBAC_NO_ROLE ��ʾ�������κν�ɫ���û�
define('RBAC_NO_ROLE',      'RBAC_NO_ROLE');

// RBAC_NULL ��ʾ������û��ֵ
define('RBAC_NULL',         'RBAC_NULL');

// ACTION_ALL ��ʾ�������е����ж���
define('ACTION_ALL',        'ACTION_ALL');
/**#@-*/

/**
 * ��ʼ�� FleaPHP ���
 */
define('G_FLEA_VAR', '__FLEA_CORE__');
$GLOBALS[G_FLEA_VAR] = array(
    'APP_INF'               => array(),
    'OBJECTS'               => array(),
    'DBO'                   => array(),
    'CLASS_PATH'            => array(),
    'FLEA_EXCEPTION_STACK'  => array(),
    'FLEA_EXCEPTION_HANDLER'=> null,
);

// ���� FleaPHP �ļ�����λ�ã��Լ���ʼ�� CLASS_PATH
$GLOBALS[G_FLEA_VAR]['CLASS_PATH'][] = dirname(__FILE__);
define('FLEA_DIR', $GLOBALS[G_FLEA_VAR]['CLASS_PATH'][0] . DS . 'FLEA');
define('FLEA_3RD_DIR', $GLOBALS[G_FLEA_VAR]['CLASS_PATH'][0] . DS . '3rd');

// ���������� FleaPHP ���ּ����Ե��ļ�
if (!defined('NO_LEGACY_FLEAPHP') || NO_LEGACY_FLEAPHP == false) {
    require(FLEA_DIR . '/Compatibility.php');
}

/**
 * ����Ĭ�������ļ�
 *
 * ���û�ж��� DEPLOY_MODE ����Ϊ true����ʹ�õ���ģʽ��ʼ�� FleaPHP
 */
if (!defined('DEPLOY_MODE') || DEPLOY_MODE != true) {
    $GLOBALS[G_FLEA_VAR]['APP_INF'] = require(FLEA_DIR . '/Config/DEBUG_MODE_CONFIG.php');
    define('DEBUG_MODE', true);
    if (!defined('DEPLOY_MODE')) { define('DEPLOY_MODE', false); }
} else {
    $GLOBALS[G_FLEA_VAR]['APP_INF'] = require(FLEA_DIR . '/Config/DEPLOY_MODE_CONFIG.php');
    define('DEBUG_MODE', false);
}

// ������ PHP5 ������ʱ�����ľ�����Ϣ
if (!defined('E_STRICT')) {
    define('E_STRICT', 2048);
}
if (DEBUG_MODE) {
    error_reporting(error_reporting(0) & ~E_STRICT);
} else {
    error_reporting(0);
}

// �����쳣��������
__SET_EXCEPTION_HANDLER('__FLEA_EXCEPTION_HANDLER');

/**
 * FLEA ���ṩ�� FleaPHP ��ܵĻ�������
 *
 * ��������з������Ǿ�̬������
 *
 * @package Core
 * @author ��Դ�Ƽ� (www.qeeyuan.com)
 * @version 1.0
 */
class FLEA
{
    /**
     * ����Ӧ�ó�������
     *
     * example:
     * <code>
     * FLEA::loadAppInf('./config/MyConfig.php');
     * </code>
     *
     * @param mixed $__config ��������������ļ���
     */
    function loadAppInf($__flea_internal_config = null)
    {
        if (!is_array($__flea_internal_config) && is_string($__flea_internal_config)) {
            if (!is_readable($__flea_internal_config)) {
                FLEA::loadClass('FLEA_Exception_ExpectedFile');
                return __THROW(new FLEA_Exception_ExpectedFile($__flea_internal_config));
            }
            $__flea_internal_config = require($__flea_internal_config);
        }
        if (is_array($__flea_internal_config)) {
            $GLOBALS[G_FLEA_VAR]['APP_INF'] = array_merge($GLOBALS[G_FLEA_VAR]['APP_INF'], $__flea_internal_config);
        }
        return null;
    }

    /**
     * ȡ��ָ�����ֵ�����ֵ
     *
     * example:
     * <code>
     * FLEA::setAppInf('siteTitle');
     * .....
     * $siteTitle = FLEA::getAppInf('siteTitle');
     * </code>
     *
     * @param string $option
     * @param mixed $default
     *
     * @return mixed
     */
    function getAppInf($option, $default = null)
    {
        return isset($GLOBALS[G_FLEA_VAR]['APP_INF'][$option]) ? $GLOBALS[G_FLEA_VAR]['APP_INF'][$option] : $default;
    }

    /**
     * ���ָ�����ֵ�����ֵ�е���Ŀ��Ҫ������ñ���������
     *
     * example:
     * <code>
     * $arr = array('min' => 1, 'max' => 100, 'step' => 2);
     * FLEA::setAppInf('rule', $arr);
     * .....
     * $min = FLEA::getAppInfValue('rule', 'min');
     * </code>
     *
     * @param string $option
     * @param string $keyname
     * @param mixed $default
     *
     * @return mixed
     */
    function getAppInfValue($option, $keyname, $default = null)
    {
        if (!isset($GLOBALS[G_FLEA_VAR]['APP_INF'][$option])) {
            $GLOBALS[G_FLEA_VAR]['APP_INF'][$option] = array();
        }
        if (array_key_exists($keyname, $GLOBALS[G_FLEA_VAR]['APP_INF'][$option])) {
            return $GLOBALS[G_FLEA_VAR]['APP_INF'][$option][$keyname];
        } else {
            $GLOBALS[G_FLEA_VAR]['APP_INF'][$option][$keyname] = $default;
            return $default;
        }
    }

    /**
     * ����ָ�����ֵ�����ֵ�е���Ŀ��Ҫ�������ֵ����������
     *
     * @param string $option
     * @param string $keyname
     * @param mixed $value
     */
    function setAppInfValue($option, $keyname, $value)
    {
        if (!isset($GLOBALS[G_FLEA_VAR]['APP_INF'][$option])) {
            $GLOBALS[G_FLEA_VAR]['APP_INF'][$option] = array();
        }
        $GLOBALS[G_FLEA_VAR]['APP_INF'][$option][$keyname] = $value;
    }

    /**
     * �޸�����ֵ
     *
     * @param string $option
     * @param mixed $data
     */
    function setAppInf($option, $data = null)
    {
        if (is_array($option)) {
            $GLOBALS[G_FLEA_VAR]['APP_INF'] = array_merge($GLOBALS[G_FLEA_VAR]['APP_INF'], $option);
        } else {
            $GLOBALS[G_FLEA_VAR]['APP_INF'][$option] = $data;
        }
    }

    /**
     * �����ļ�����·��
     *
     * FLEA::loadClass()��FLEA::getSingleton() ��������·���в���ָ�����ֵ��ඨ���ļ���
     * �����Ҫ���� FLEA::import() ������ඨ���ļ���Ŀ¼��ӵ�����·���С�
     * ���ǣ���Ӧ�ý����ļ�����Ŀ¼ֱ����ӵ�����·���У����Ǹ����������������Ҫ�����һ��Ŀ¼��
     *
     * ������������ Table_Posts����ʵ�ʵ��ļ��� ./APP/Table/Posts.php��
     * ��ôӦ����ӵ�Ŀ¼���� ./APP�������� ./APP/Table ��
     *
     * example:
     * <code>
     * FLEA::import(APP_DIR . '/LIBS');
     * </code>
     *
     * @param string $dir
     */
    function import($dir)
    {
        if (array_search($dir, $GLOBALS[G_FLEA_VAR]['CLASS_PATH'], true)) { return; }
        if (DIRECTORY_SEPARATOR == '/') {
            $dir = str_replace('\\', DIRECTORY_SEPARATOR, $dir);
        } else {
            $dir = str_replace('/', DIRECTORY_SEPARATOR, $dir);
        }
        $GLOBALS[G_FLEA_VAR]['CLASS_PATH'][] = $dir;
    }

    /**
     * ����ָ�����ļ�
     *
     * FLEA::loadFile() �� $filename �����е� ��_�� �滻ΪĿ¼�����磺
     *
     * example:
     * <code>
     * FLEA::loadFile('Table_Posts.php');
     * // ��ͬ�� include 'Table/Posts.php';
     * </code>
     *
     * @param string $className
     * @param boolean $loadOnce ָ��Ϊ true ʱ��FLEA::loadFile() ��ͬ�� require_once
     *
     * @return boolean
     */
    function loadFile($filename, $loadOnce = false)
    {
        static $is_loaded = array();

        $path = FLEA::getFilePath($filename);
        if ($path != '') {
            if (isset($is_loaded[$path]) && $loadOnce) { return true; }
            $is_loaded[$path] = true;
            if ($loadOnce) {
                return require_once($path);
            } else {
                return require($path);
            }
        }

        FLEA::loadClass('FLEA_Exception_ExpectedFile');
        __THROW(new FLEA_Exception_ExpectedFile($filename));
        return false;
    }

    /**
     * ����ָ����Ķ����ļ�
     *
     * �������е� ��_�� �ᱻ�滻ΪĿ¼��Ȼ�������·���в��Ҹ���Ķ����ļ���
     *
     * example:
     * <code>
     * FLEA::loadClass('Table_Posts');
     * // ���Ƚ������� Table_Posts ת��Ϊ�ļ��� Table/Posts.php
     * // Ȼ�������·���в��� Table/Posts.php �ļ�
     * </code>
     *
     * @param string $filename
     * @param boolean $noException ���Ϊ true�����ඨ���ļ�û�ҵ�ʱ���׳��쳣
     *
     * @return boolean
     */
    function loadClass($className, $noException = false)
    {
        if (PHP5) {
            if (class_exists($className, false) || interface_exists($className, false)) { return true; }
        } else {
            if (class_exists($className)) { return true; }
        }

        if (preg_match('/[^a-z0-9\-_.]/i', $className) === 0) {
            $filename = FLEA::getFilePath($className . '.php');
            if ($filename) {
                require($filename);
                if (PHP5) {
                    if (class_exists($className, false) || interface_exists($className, false)) { return true; }
                } else {
                    if (class_exists($className)) { return true; }
                }
            }
        }

        if ($noException) { return false; }

        $filename = FLEA::getFilePath($className . '.php', true);
        require_once(FLEA_DIR . '/Exception/ExpectedClass.php');
        __THROW(new FLEA_Exception_ExpectedClass($className, $filename, file_exists($filename)));
        return false;
    }

    /**
     * ���� FleaPHP ���������������ļ�
     *
     * FleaPHP ��������������ļ����еġ�_���滻ΪĿ¼�ָ�����
     *
     * @param string $filename
     * @param boolean $return ָʾ�Ƿ�ֱ�ӷ��ش������ļ����������ж��ļ��Ƿ����
     *
     * @return string
     */
    function getFilePath($filename, $return = false)
    {
        $filename = str_replace('_', DIRECTORY_SEPARATOR, $filename);
        if (DIRECTORY_SEPARATOR == '/') {
            $filename = str_replace('\\', DIRECTORY_SEPARATOR, $filename);
        } else {
            $filename = str_replace('/', DIRECTORY_SEPARATOR, $filename);
        }

        if (strtolower(substr($filename, -4)) != '.php') {
            $filename .= '.php';
        }

        // ����������ǰĿ¼
        if (is_file($filename)) { return $filename; }

        foreach ($GLOBALS[G_FLEA_VAR]['CLASS_PATH'] as $classdir) {
            $path = $classdir . DIRECTORY_SEPARATOR . $filename;
            if (is_file($path)) { return $path; }
        }

        if ($return) { return $filename; }
        return false;
    }

    /**
     * ����ָ�����Ψһһ��ʵ��
     *
     * example:
     * <code>
     * $obj =& FLEA::getSingleton('Table_Posts);
     * ......
     * $obj2 =& FLEA::getSingleton('Table_Posts);
     * // ���������λ�ȡ���Ƿ���ͬһ��ʵ��
     * echo $obj === $obj2 ? 'Equals' : 'Not equals';
     * </code>
     *
     * @param string $className
     *
     * @return object
     */
    function & getSingleton($className)
    {
        static $instances = array();
        if (FLEA::isRegistered($className)) {
            // �����Ѿ����ڵĶ���ʵ��
            return FLEA::registry($className);
        }
        if (PHP5) {
            $classExists = class_exists($className, false);
        } else {
            $classExists = class_exists($className);
        }
        if (!$classExists) {
            if (!FLEA::loadClass($className)) {
                $return = false;
                return $return;
            }
        }

        $instances[$className] =& new $className();
        FLEA::register($instances[$className], $className);
        return $instances[$className];
    }

    /**
     * ��һ������ʵ��ע�ᵽ����ʵ���������Ա��Ժ�ȡ��
     *
     * example:
     * <code>
     * $obj =& new MyClass();
     * // ������ע�ᵽ����
     * FLEA::register($obj, 'MyClass');
     * .....
     * // ����������ָ���Ķ���
     * $obj2 =&  FLEA::registry('MyClass');
     * // ����Ƿ���ͬһ��ʵ��
     * echo $obj === $obj2 ? 'Equals' : 'Not equals';
     * </code>
     *
     * @param object $obj
     * @param string $name
     *
     * @return object
     */
    function & register(& $obj, $name = null)
    {
        if (!is_object($obj)) {
            FLEA::loadClass('FLEA_Exception_TypeMismatch');
            return __THROW(new FLEA_Exception_TypeMismatch($obj, 'object', gettype($obj)));
        }

        if (is_null($name)) {
            $name = get_class($obj);
        }

        if (isset($GLOBALS[G_FLEA_VAR]['OBJECTS'][$name])) {
            FLEA::loadClass('FLEA_Exception_ExistsKeyName');
            return __THROW(new FLEA_Exception_ExistsKeyName($name));
        } else {
            $GLOBALS[G_FLEA_VAR]['OBJECTS'][$name] =& $obj;
            return $obj;
        }
    }

    /**
     * �Ӷ���ʵ��������ȡ��ָ�����ֵĶ���ʵ�������û��ָ�������򷵻ذ������ж��������
     *
     * example:�ο� FLEA::register()
     *
     * @param string $name
     *
     * @return object
     */
    function & registry($name = null)
    {
        if (is_null($name)) {
            return $GLOBALS[G_FLEA_VAR]['OBJECTS'];
        }
        if (isset($GLOBALS[G_FLEA_VAR]['OBJECTS'][$name]) && is_object($GLOBALS[G_FLEA_VAR]['OBJECTS'][$name])) {
            return $GLOBALS[G_FLEA_VAR]['OBJECTS'][$name];
        }
        FLEA::loadClass('FLEA_Exception_NotExistsKeyName');
        return __THROW(new FLEA_Exception_NotExistsKeyName($name));
    }

    /**
     * ���ָ�����ֵĶ����Ƿ��Ѿ�ע��
     *
     * example:
     * <code>
     * if (FLEA::isRegistered('MyClass')) {
     *      $obj =& FLEA::registry('MyClass');
     * } else {
     *      $obj =& new MyClass();
     * }
     * </code>
     *
     * @param string $name
     *
     * @return boolean
     */
    function isRegistered($name)
    {
        return isset($GLOBALS[G_FLEA_VAR]['OBJECTS'][$name]);
    }


    /**
     * ��ȡָ����������ݣ�����������ݲ����ڻ�ʧЧ���򷵻� false
     *
     * example:
     * <code>
     * $cacheId = 'my_cache_id';
     * if (!($data = FLEA::getCache($cacheId))) {
     *      $data = 'Data';
     *      FLEA::writeCache($cacheId, $data);
     * }
     * </code>
     *
     * ��� $cacheIdIsFilename ����Ϊ true�������ɵĻ����ļ����� $cacheId ������Ϊ�ļ�����
     * ���ڰ�ȫԭ�򣬾�����Ҫ�� $cacheIdIsFilename ��������Ϊ true��
     *
     * $time ����Ĭ��Ϊ�������ݵ���Ч�ڡ�������������Ի����ļ���������ʱ��Ϊ׼��Ҳ�������һ�θ��¸û������ݵ�ʱ�䣩��
     *
     * ��� $timeIsLifetime Ϊ false���� $time ������ʾ���ںͻ����ļ������ʱ����бȽϵ����ݡ�
     * ��� $time ָ����ʱ�����ڻ����ļ���������ʱ�䣬���жϻ�������Ϊ��Ч��
     *
     * @param string $cacheId ����ID����ͬ�Ļ�������Ӧ��ʹ�ò�ͬ��ID
     * @param int $time �������ʱ��򻺴���������
     * @param boolean $timeIsLifetime ָʾ $time ����������
     * @param boolean $cacheIdIsFilename ָʾ�Ƿ��� $cacheId ��Ϊ�ļ���
     *
     * @return mixed ���ػ�������ݣ����治���ڻ�ʧЧ�򷵻� false
     */
    function getCache($cacheId, $time = 900, $timeIsLifetime = true, $cacheIdIsFilename = false)
    {
        $cacheDir = FLEA::getAppInf('internalCacheDir');
        if (is_null($cacheDir)) {
            FLEA::loadClass('FLEA_Exception_CacheDisabled');
            __THROW(new FLEA_Exception_CacheDisabled($cacheDir));
            return false;
        }

        if ($cacheIdIsFilename) {
            $cacheFile = $cacheDir . DS . preg_replace('/[^a-z0-9\-_]/i', '_', $cacheId) . '.php';
        } else {
            $cacheFile = $cacheDir . DS . md5($cacheId) . '.php';
        }
        if (!file_exists($cacheFile)) { return false; }

        if ($timeIsLifetime && $time == -1) {
            $data = safe_file_get_contents($cacheFile);
            $hash = substr($data, 16, 32);
            $data = substr($data, 48);
            if (crc32($data) != $hash || strlen($hash) != 32) {
                return false;
            }
            return $data !== false ? unserialize($data) : false;
        }

        $filetime = filemtime($cacheFile);
        if ($timeIsLifetime) {
            if (time() >= $filetime + $time) { return false; }
        } else {
            if ($time >= $filetime) { return false; }
        }
        $data = safe_file_get_contents($cacheFile);
        $hash = substr($data, 16, 32);
        $data = substr($data, 48);
        if (crc32($data) != $hash || strlen($hash) != 32) {
            return false;
        }
        return $data !== false ? unserialize($data) : false;
    }

    /**
     * ����������д�뻺��
     *
     * example:
     * <code>
     * $data = .....; // Ҫ��������ݣ��������κ����͵�ֵ
     * // cache id ����Ψһָ��һ���������ݣ��Ա��Ժ�ȡ����������
     * $cacheId = 'data_cahce_1';
     * FLEA::writeCache($cacheId, $data);
     * </code>
     *
     * @param string $cacheId
     * @param mixed $data
     * @param boolean $cacheIdIsFilename
     *
     * @return boolean
     */
    function writeCache($cacheId, $data, $cacheIdIsFilename = false)
    {
        $cacheDir = FLEA::getAppInf('internalCacheDir');
        if (is_null($cacheDir)) {
            FLEA::loadClass('FLEA_Exception_CacheDisabled');
            __THROW(new FLEA_Exception_CacheDisabled($cacheDir));
            return false;
        }

        if ($cacheIdIsFilename) {
            $cacheFile = $cacheDir . DS . preg_replace('/[^a-z0-9\-_]/i', '_', $cacheId) . '.php';
        } else {
            $cacheFile = $cacheDir . DS . md5($cacheId) . '.php';
        }

        $data = serialize($data);
        $prefix = '<?php die(); ?> ';
        $hash = sprintf('% 32d', crc32($data));
        $data = $prefix . $hash . $data;

        if (!safe_file_put_contents($cacheFile, $data)) {
            FLEA::loadClass('FLEA_Exception_CacheDisabled');
            __THROW(new FLEA_Exception_CacheDisabled($cacheDir));
            return false;
        } else {
            return true;
        }
    }

    /**
     * ɾ��ָ���Ļ�������
     *
     * @param string $cacheId
     * @param boolean $cacheIdIsFilename
     *
     * @return boolean
     */
    function purgeCache($cacheId, $cacheIdIsFilename = false)
    {
        $cacheDir = FLEA::getAppInf('internalCacheDir');
        if (is_null($cacheDir)) {
            FLEA::loadClass('FLEA_Exception_CacheDisabled');
            __THROW(new FLEA_Exception_CacheDisabled($cacheDir));
            return false;
        }

        if ($cacheIdIsFilename) {
            $cacheFile = $cacheDir . DS . preg_replace('/[^a-z0-9\-_]/i', '_', $cacheId) . '.php';
        } else {
            $cacheFile = $cacheDir . DS . md5($cacheId) . '.php';
        }

        if (file_exists($cacheFile)) {
            return unlink($cacheFile);
        }
        return true;
    }


    /**
     * ��ʼ�� WebControls������ FLEA_WebControls ����ʵ��
     *
     * �����޸�Ӧ�ó������� webControlsClassName��ָ����һ�� WebControls �ࡣ
     *
     * @return FLEA_WebControls
     */
    function & initWebControls()
    {
        return FLEA::getSingleton(FLEA::getAppInf('webControlsClassName'));
    }

    /**
     * ��ʼ�� Ajax������ FLEA_Ajax ����ʵ��
     *
     * �����޸�Ӧ�ó������� ajaxClassName��ָ����һ�� Ajax �ࡣ
     *
     * @return FLEA_Ajax
     */
    function & initAjax()
    {
        return FLEA::getSingleton(FLEA::getAppInf('ajaxClassName'));
    }

    /**
     * ����һ������
     *
     * ���е����ֶ�������Ӧ�ó��������У������� helper. ��ͷ��
     * ���� helper.array ָ��Ϊ FLEA_Helper_Array��helper.image ָ��Ϊ FLEA_Helper_Image��
     *
     * @param string $helperName
     */
    function loadHelper($helperName)
    {
        $settingName = 'helper.' . strtolower($helperName);
        $setting = FLEA::getAppInf($settingName);
        if ($setting) {
            return FLEA::loadFile($setting, true);
        } else {
            FLEA::loadClass('FLEA_Exception_NotExistsKeyName');
            return __THROW(new FLEA_Exception_NotExistsKeyName('helper.' . $helperName));
        }
    }

    /**
     * �������ݿ���ʶ���ʵ��
     *
     * ������ṩ $dsn ���������� $dsn ����Ϊ 0������Ӧ�ó������� dbDSN Ϊ DSN ��Ϣ��
     *
     * DSN �� Database Source Name ����д���������Ϊ����Դ���֡�
     * �� FleaPHP �У�DSN ��һ�����飬�������������ݿ���Ҫ�ĸ�����Ϣ�������������û���������ȡ�
     *
     * DSN ����ȷд����
     *
     * example:
     * <code>
     * $dsn = array(
     *      'driver'   => 'mysql',
     *      'host'     => 'localhost',
     *      'login'    => 'username',
     *      'password' => 'password',
     *      'database' => 'test_db',
     *      'charset'  => 'utf8',
     * );
     *
     * $dbo =& FLEA::getDBO($dsn);
     * </code>
     *
     * @param array|string|int $dsn
     *
     * @return FLEA_Db_Driver_Abstract
     */
    function & getDBO($dsn = 0)
    {
        if ($dsn == 0) {
            $dsn = FLEA::getAppInf('dbDSN');
        }
        $dsn = FLEA::parseDSN($dsn);

        if (!is_array($dsn) || !isset($dsn['driver'])) {
            FLEA::loadClass('FLEA_Db_Exception_InvalidDSN');
            return __THROW(new FLEA_Db_Exception_InvalidDSN($dsn));
        }

        $dsnid = $dsn['id'];
        if (isset($GLOBALS[G_FLEA_VAR]['DBO'][$dsnid])) {
            return $GLOBALS[G_FLEA_VAR]['DBO'][$dsnid];
        }

        $driver = ucfirst(strtolower($dsn['driver']));
        $className = 'FLEA_Db_Driver_' . $driver;
        if ($driver == 'Mysql' || $driver == 'Mysqlt') {
            require_once(FLEA_DIR . '/Db/Driver/Mysql.php');
        } else {
            FLEA::loadClass($className);
        }
        $dbo =& new $className($dsn);
        /* @var $dbo FLEA_Db_Driver_Abstract */
        $dbo->connect();

        $GLOBALS[G_FLEA_VAR]['DBO'][$dsnid] =& $dbo;
        return $GLOBALS[G_FLEA_VAR]['DBO'][$dsnid];
    }

    /**
     * ���� DSN �ַ��������飬���ذ��� DSN ������Ϣ�����飬ʧ�ܷ��� false
     *
     * @param string|array $dsn
     *
     * @return array
     */
    function parseDSN($dsn)
    {
        if (is_array($dsn)) {
            $dsn['host'] = isset($dsn['host']) ? $dsn['host'] : '';
            $dsn['port'] = isset($dsn['port']) ? $dsn['port'] : '';
            $dsn['login'] = isset($dsn['login']) ? $dsn['login'] : '';
            $dsn['password'] = isset($dsn['password']) ? $dsn['password'] : '';
            $dsn['database'] = isset($dsn['database']) ? $dsn['database'] : '';
            $dsn['options'] = isset($dsn['options']) ? $dsn['options'] : '';
            $dsn['prefix'] = isset($dsn['prefix']) ? $dsn['prefix'] : FLEA::getAppInf('dbTablePrefix');
            $dsn['schema'] = isset($dsn['schema']) ? $dsn['schema'] : '';
        } else {
            $dsn = str_replace('@/', '@localhost/', $dsn);
            $parse = parse_url($dsn);
            if (empty($parse['scheme'])) { return false; }

            $dsn = array();
            $dsn['host']     = isset($parse['host']) ? $parse['host'] : 'localhost';
            $dsn['port']     = isset($parse['port']) ? $parse['port'] : '';
            $dsn['login']    = isset($parse['user']) ? $parse['user'] : '';
            $dsn['password'] = isset($parse['pass']) ? $parse['pass'] : '';
            $dsn['driver']   = isset($parse['scheme']) ? strtolower($parse['scheme']) : '';
            $dsn['database'] = isset($parse['path']) ? substr($parse['path'], 1) : '';
            $dsn['options']  = isset($parse['query']) ? $parse['query'] : '';
            $dsn['prefix'] = FLEA::getAppInf('dbTablePrefix');
            $dsn['schema']   = '';
        }
        $dsnid = "{$dsn['driver']}://{$dsn['login']}:{$dsn['password']}@{$dsn['host']}_{$dsn['prefix']}/{$dsn['database']}/{$dsn['schema']}/{$dsn['options']}";
        $dsn['id'] = $dsnid;
        return $dsn;
    }

    /**
     * FleaPHP Ӧ�ó��� MVC ģʽ���
     *
     * ���Ӧ�ó�����Ҫʹ�� FleaPHP �ṩ�� MVC ģʽ���������� FLEA.php ���Զ����Ӧ�ó������ú�Ӧ�õ��� FLEA::runMVC() ����Ӧ�ó���
     */
    function runMVC()
    {
        $MVCPackageFilename = FLEA::getAppInf('MVCPackageFilename');
        if ($MVCPackageFilename != '') {
            require_once($MVCPackageFilename);
        }
        FLEA::init();

        // �����������ת�����󵽿�����
        $dispatcherClass = FLEA::getAppInf('dispatcher');
        FLEA::loadClass($dispatcherClass);

        $dispatcher =& new $dispatcherClass($_GET);
        FLEA::register($dispatcher, $dispatcherClass);
        $dispatcher->dispatching();
    }

    /**
     * ׼�����л���
     *
     * @param boolean $loadMVC
     */
    function init($loadMVC = false)
    {
        static $firstTime = true;

        // �����ظ����� FLEA::init()
        if (!$firstTime) { return; }
        $firstTime = false;

        // ����Ĭ��ʱ��
        if (function_exists('date_default_timezone_set')) {
            $timezone = FLEA::getAppInf('defaultTimezone');
            if (empty($timezone)) {
                $timezone = ini_get('date.timezone');
                if (empty($timezone)) {
                    // ���������û��ָ������ʹ�� Asia/ShangHai
                    date_default_timezone_set('Asia/ShangHai');
                }
            } else {
                date_default_timezone_set($timezone);
            }
        }

        /**
         * ��װӦ�ó���ָ�����쳣��������
         */
        __SET_EXCEPTION_HANDLER(FLEA::getAppInf('exceptionHandler'));
        if (PHP5) {
            set_exception_handler(FLEA::getAppInf('exceptionHandler'));
        }

        /**
         * ������־�����ṩ����
         */
        if (FLEA::getAppInf('logEnabled') && FLEA::getAppInf('logProvider')) {
            FLEA::loadClass(FLEA::getAppInf('logProvider'));
        }
        if (!function_exists('log_message')) {
            // ���û��ָ����־�����ṩ���򣬾Ͷ���һ���յ� log_message() ����
            function log_message() {};
        }

        /**
         * ���û��ָ������Ŀ¼����ʹ��Ĭ�ϵĻ���Ŀ¼
         */
        $cachedir = FLEA::getAppInf('internalCacheDir');
        if (empty($cachedir)) {
            FLEA::setAppInf('internalCacheDir', dirname(__FILE__) . DS . '_Cache');
        }

        // ���� magic_quotes
        if (get_magic_quotes_gpc()) {
            $in = array(& $_GET, & $_POST, & $_COOKIE, & $_REQUEST);
            while (list($k,$v) = each($in)) {
                foreach ($v as $key => $val) {
                    if (!is_array($val)) {
                        $in[$k][$key] = stripslashes($val);
                        continue;
                    }
                    $in[] =& $in[$k][$key];
                }
            }
            unset($in);
        }
        set_magic_quotes_runtime(0);

        // ���� URL ģʽ���ã������Ƿ�Ҫ���� URL ����������
        if (FLEA::getAppInf('urlMode') != URL_STANDARD) {
            require(FLEA_DIR . '/Filter/Uri.php');
        }

        // ���� requestFilters
        foreach ((array)FLEA::getAppInf('requestFilters') as $file) {
            FLEA::loadFile($file);
        }

        // ���� $loadMVC
        if ($loadMVC) {
            $MVCPackageFilename = FLEA::getAppInf('MVCPackageFilename');
            if ($MVCPackageFilename != '') {
                require_once($MVCPackageFilename);
            }
        }

        // ���� autoLoad
        foreach ((array)FLEA::getAppInf('autoLoad') as $file) {
            FLEA::loadFile($file);
        }

        // ����ָ���� session �����ṩ����
        if (FLEA::getAppInf('sessionProvider')) {
            FLEA::getSingleton(FLEA::getAppInf('sessionProvider'));
        }
        // �Զ����� session �Ự
        if (FLEA::getAppInf('autoSessionStart')) {
            session_start();
        }

        // ���� I18N ��صĳ���
        define('RESPONSE_CHARSET', FLEA::getAppInf('responseCharset'));
        define('DATABASE_CHARSET', FLEA::getAppInf('databaseCharset'));

        // ����Ƿ����ö�����֧��
        if (FLEA::getAppInf('multiLanguageSupport')) {
            FLEA::loadClass(FLEA::getAppInf('languageSupportProvider'));
        }
        if (!function_exists('_T')) {
            function _T() {};
        }

        // �Զ��������ͷ��Ϣ
        if (FLEA::getAppInf('autoResponseHeader')) {
            header('Content-Type: text/html; charset=' . FLEA::getAppInf('responseCharset'));
        }
    }
}

/**
 * ���� FleaPHP ������ȫ�ֺ���
 */

/**
 * �ض����������ָ���� URL
 *
 * @param string $url Ҫ�ض���� url
 * @param int $delay �ȴ��������Ժ���ת
 * @param bool $js ָʾ�Ƿ񷵻�������ת�� JavaScript ����
 * @param bool $jsWrapped ָʾ���� JavaScript ����ʱ�Ƿ�ʹ�� <script> ��ǩ���а�װ
 * @param bool $return ָʾ�Ƿ񷵻����ɵ� JavaScript ����
 */
function redirect($url, $delay = 0, $js = false, $jsWrapped = true, $return = false)
{
    $delay = (int)$delay;
    if (!$js) {
        if (headers_sent() || $delay > 0) {
            echo <<<EOT
    <html>
    <head>
    <meta http-equiv="refresh" content="{$delay};URL={$url}" />
    </head>
    </html>
EOT;
            exit;
        } else {
            header("Location: {$url}");
            exit;
        }
    }

    $out = '';
    if ($jsWrapped) {
        $out .= '<script language="JavaScript" type="text/javascript">';
    }
    if ($delay > 0) {
        $out .= "window.setTimeout(function () { document.location='{$url}'; }, {$delay});";
    } else {
        $out .= "document.location='{$url}';";
    }
    if ($jsWrapped) {
        $out .= '</script>';
    }

    if ($return) {
        return $out;
    }

    echo $out;
    exit;
}

/**
 * ���� url
 *
 * ���� url ��Ҫ�ṩ�������������������ƺͿ����������������ʡ��������������������һ����
 * �� url() ������ʹ��Ӧ�ó��������е�ȷ����Ĭ�Ͽ������ƺ�Ĭ�Ͽ�������������
 *
 * url() �����Ӧ�ó������� urlMode ���ɲ�ͬ�� URL ��ַ��
 * - URL_STANDARD - ��׼ģʽ��Ĭ�ϣ������� index.php?url=Login&action=Reject&id=1
 * - URL_PATHINFO - PATHINFO ģʽ������ index.php/Login/Reject/id/1
 * - URL_REWRITE  - URL ��дģʽ������ /Login/Reject/id/1
 *
 * ���ɵ� url ��ַ����Ҫ������Ӧ�ó������õ�Ӱ�죺
 *   - controllerAccessor
 *   - defaultController
 *   - actionAccessor
 *   - defaultAction
 *   - urlMode
 *   - urlLowerChar
 *
 * �÷���
 * <code>
 * $url = url('Login', 'checkUser');
 * // $url ����Ϊ ?controller=Login&action=checkUser
 *
 * $url = url('Login', 'checkUser', array('username' => 'dualface'));
 * // $url ����Ϊ ?controller=Login&action=checkUser&username=dualface
 *
 * $url = url('Article', 'View', array('id' => 1'), '#details');
 * // $url ����Ϊ ?controller=Article&action=View&id=1#details
 * </code>
 *
 * @param string $controllerName
 * @param string $actionName
 * @param array $params
 * @param string $anchor
 * @param array $options
 *
 * @return string
 */
function url($controllerName = null, $actionName = null, $params = null, $anchor = null, $options = null)
{
    static $baseurl = null, $currentBootstrap = null;

    $callback = FLEA::getAppInf('urlCallback');
    if (!empty($callback)) {
        call_user_func_array($callback, array(& $controllerName, & $actionName, & $params, & $anchor, & $options));
    }

    // ȷ����ǰ�� URL ������ַ������ļ���
    if (is_null($baseurl)) {
        $baseurl = detect_uri_base();
        $p = strrpos($baseurl, '/');
        $currentBootstrap = substr($baseurl, $p + 1);
        $baseurl = substr($baseurl, 0, $p);
    }

    // ȷ������ url Ҫʹ�õ� bootstrap
    $options = (array)$options;
    if (isset($options['bootstrap'])) {
        $bootstrap = $options['bootstrap'];
    } else if ($currentBootstrap == '') {
        $bootstrap = FLEA::getAppInf('urlBootstrap');
    } else {
        $bootstrap = $currentBootstrap;
    }

    // ȷ���������Ͷ���������
    $defaultController = FLEA::getAppInf('defaultController');
    $defaultAction = FLEA::getAppInf('defaultAction');
    $lowerChar = isset($options['lowerChar']) ? $options['lowerChar'] : FLEA::getAppInf('urlLowerChar');
    if ($lowerChar) {
        $defaultController = strtolower($defaultController);
        $defaultAction = strtolower($defaultAction);
    }

    if ($bootstrap != $currentBootstrap && $currentBootstrap != '') {
        $controllerName = !empty($controllerName) ? $controllerName : null;
        $actionName = !empty($actionName) ? $actionName : null;
    } else {
        $controllerName = !empty($controllerName) ? $controllerName : $defaultController;
        $actionName = !empty($actionName) ? $actionName : $defaultAction;
    }
    if ($lowerChar) {
        $controllerName = strtolower($controllerName);
        $actionName = strtolower($actionName);
    }

    $url = '';
    $mode = isset($options['mode']) ? $options['mode'] : FLEA::getAppInf('urlMode');

    // PATHINFO �� REWRITE ģʽ
    if ($mode == URL_PATHINFO || $mode == URL_REWRITE) {
        $url = $baseurl;
        if ($mode == URL_PATHINFO) {
            $url .= '/' . $bootstrap;
        }
        if ($controllerName != '' && $actionName != '') {
            $pps = isset($options['parameterPairStyle']) ? $options['parameterPairStyle'] : FLEA::getAppInf('urlParameterPairStyle');
            $url .= '/' . rawurlencode($controllerName);
            if (is_array($params) && !empty($params)) {
                $url .= '/' . rawurlencode($actionName);
                $url .= '/' . encode_url_args($params, $mode, $pps);
            } else {
                if (FLEA::getAppInf('urlAlwaysUseAccessor') || $actionName != $defaultAction) {
                    $url .= '/' . rawurlencode($actionName);
                }
            }
        }
        if ($anchor) { $url .= '#' . $anchor; }
        return $url;
    }

    // ��׼ģʽ
    $alwaysUseBootstrap = isset($options['alwaysUseBootstrap']) ? $options['alwaysUseBootstrap'] : FLEA::getAppInf('urlAlwaysUseBootstrap');
    $url = $baseurl . '/';

    if ($alwaysUseBootstrap || $bootstrap != FLEA::getAppInf('urlBootstrap')) {
        $url .= $bootstrap;
    }

    $parajoin = '?';
    if (FLEA::getAppInf('urlAlwaysUseAccessor')) {
        $defaultController = '';
        $defaultAction = '';
    }
    if ($controllerName != $defaultController && !is_null($controllerName)) {
        $url .= $parajoin . FLEA::getAppInf('controllerAccessor'). '=' . $controllerName;
        $parajoin = '&';
    }
    if ($actionName != $defaultAction && !is_null($actionName)) {
        $url .= $parajoin . FLEA::getAppInf('actionAccessor') . '=' . $actionName;
        $parajoin = '&';
    }

    if (is_array($params) && !empty($params)) {
        $url .= $parajoin . encode_url_args($params, $mode);
    }
    if ($anchor) { $url .= '#' . $anchor; }

    return $url;
}

/**
 * ��õ�ǰ����� URL ��ַ
 *
 * �ο� QeePHP �� Zend Framework ʵ�֡�
 *
 * @return string
 */
function detect_uri_base()
{
    static $baseuri = null;

    if ($baseuri) { return $baseuri; }
    $filename = basename($_SERVER['SCRIPT_FILENAME']);

    if (basename($_SERVER['SCRIPT_NAME']) === $filename) {
        $url = $_SERVER['SCRIPT_NAME'];
    } elseif (basename($_SERVER['PHP_SELF']) === $filename) {
        $url = $_SERVER['PHP_SELF'];
    } elseif (isset($_SERVER['ORIG_SCRIPT_NAME']) && basename($_SERVER['ORIG_SCRIPT_NAME']) === $filename) {
        $url = $_SERVER['ORIG_SCRIPT_NAME']; // 1and1 shared hosting compatibility
    } else {
        // Backtrack up the script_filename to find the portion matching
        // php_self
        $path    = $_SERVER['PHP_SELF'];
        $segs    = explode('/', trim($_SERVER['SCRIPT_FILENAME'], '/'));
        $segs    = array_reverse($segs);
        $index   = 0;
        $last    = count($segs);
        $url = '';
        do {
            $seg     = $segs[$index];
            $url = '/' . $seg . $url;
            ++$index;
        } while (($last > $index) && (false !== ($pos = strpos($path, $url))) && (0 != $pos));
    }

    // Does the baseUrl have anything in common with the request_uri?
    if (isset($_SERVER['HTTP_X_REWRITE_URL'])) { // check this first so IIS will catch
        $request_uri = $_SERVER['HTTP_X_REWRITE_URL'];
    } elseif (isset($_SERVER['REQUEST_URI'])) {
        $request_uri = $_SERVER['REQUEST_URI'];
    } elseif (isset($_SERVER['ORIG_PATH_INFO'])) { // IIS 5.0, PHP as CGI
        $request_uri = $_SERVER['ORIG_PATH_INFO'];
        if (!empty($_SERVER['QUERY_STRING'])) {
            $request_uri .= '?' . $_SERVER['QUERY_STRING'];
        }
    } else {
        $request_uri = '';
    }

    if (0 === strpos($request_uri, $url)) {
        // full $url matches
        $baseuri = $url;
        return $baseuri;
    }

    if (0 === strpos($request_uri, dirname($url))) {
        // directory portion of $url matches
        $baseuri = rtrim(dirname($url), '/') . '/';
        return $baseuri;
    }

    if (!strpos($request_uri, basename($url))) {
        // no match whatsoever; set it blank
        return '';
    }

    // If using mod_rewrite or ISAPI_Rewrite strip the script filename
    // out of baseUrl. $pos !== 0 makes sure it is not matching a value
    // from PATH_INFO or QUERY_STRING
    if ((strlen($request_uri) >= strlen($url))
        && ((false !== ($pos = strpos($request_uri, $url))) && ($pos !== 0)))
    {
        $url = substr($request_uri, 0, $pos + strlen($url));
    }

    $baseuri = rtrim($url, '/') . '/';
    return $baseuri;
}

/**
 * ������ת��Ϊ��ͨ�� url ���ݵ��ַ�������
 *
 * �÷���
 * <code>
 * $string = encode_url_args(array('username' => 'dualface', 'mode' => 'md5'));
 * // $string ����Ϊ username=dualface&mode=md5
 * </code>
 *
 * @param array $args
 * @param enum $urlMode
 * @param string $parameterPairStyle
 *
 * @return string
 */
function encode_url_args($args, $urlMode = URL_STANDARD, $parameterPairStyle = null)
{
    $str = '';
    switch ($urlMode) {
    case URL_STANDARD:
        if (is_null($parameterPairStyle)) {
            $parameterPairStyle = '=';
        }
        $sc = '&';
        break;
    case URL_PATHINFO:
    case URL_REWRITE:
        if (is_null($parameterPairStyle)) {
            $parameterPairStyle = FLEA::getAppInf('urlParameterPairStyle');
        }
        $sc = '/';
        break;
    }

    foreach ($args as $key => $value) {
        if (is_null($value) || $value === '') { continue; }
        if (is_array($value)) {
            $append = encode_url_args($value, $urlMode);
        } else {
            $append = rawurlencode($key) . $parameterPairStyle . rawurlencode($value);
        }
        if (substr($str, -1) != $sc) {
            $str .= $sc;
        }
        $str .= $append;
    }
    return substr($str, 1);
}

/**
 * ת�� HTML �����ַ�����ͬ�� htmlspecialchars()
 *
 * @param string $text
 *
 * @return string
 */
function h($text)
{
    return htmlspecialchars($text);
}

/**
 * ת�� HTML �����ַ��Լ��ո�ͻ��з�
 *
 * �ո��滻Ϊ &nbsp; �����з��滻Ϊ <br />��
 *
 * @param string $text
 *
 * @return string
 */
function t($text)
{
    return nl2br(str_replace(' ', '&nbsp;', htmlspecialchars($text)));
}

/**
 * ͨ�� JavaScript �ű���ʾ��ʾ�Ի��򣬲��رմ��ڻ����ض��������
 *
 * �÷���
 * <code>
 * js_alert('Dialog message', '', $url);
 * // ����
 * js_alert('Dialog message', 'window.close();');
 * </code>
 *
 * @param string $message Ҫ��ʾ����Ϣ
 * @param string $after_action ��ʾ��Ϣ��Ҫִ�еĶ���
 * @param string $url �ض���λ��
 */
function js_alert($message = '', $after_action = '', $url = '')
{
    $out = "<script language=\"javascript\" type=\"text/javascript\">\n";
    if (!empty($message)) {
        $out .= "alert(\"";
        $out .= str_replace("\\\\n", "\\n", t2js(addslashes($message)));
        $out .= "\");\n";
    }
    if (!empty($after_action)) {
        $out .= $after_action . "\n";
    }
    if (!empty($url)) {
        $out .= "document.location.href=\"";
        $out .= $url;
        $out .= "\";\n";
    }
    $out .= "</script>";
    echo $out;
    exit;
}

/**
 * �������ַ���ת��Ϊ JavaScript �ַ�������������β��"��
 *
 * @param string $content
 *
 * @return string
 */
function t2js($content)
{
    return str_replace(array("\r", "\n"), array('', '\n'), addslashes($content));
}

/**
 * safe_file_put_contents() һ������ɴ��ļ���д�����ݣ��ر��ļ������������ȷ��д��ʱ������ɲ�����ͻ
 *
 * @param string $filename
 * @param string $content
 * @param int $flag
 *
 * @return boolean
 */
function safe_file_put_contents($filename, & $content)
{
    $fp = fopen($filename, 'wb');
    if ($fp) {
        flock($fp, LOCK_EX);
        fwrite($fp, $content);
        flock($fp, LOCK_UN);
        fclose($fp);
        return true;
    } else {
        return false;
    }
}

/**
 * safe_file_get_contents() �ù�����ģʽ���ļ�����ȡ���ݣ����Ա����ڲ���д����ɵĶ�ȡ����������
 *
 * @param string $filename
 *
 * @return mixed
 */
function safe_file_get_contents($filename)
{
    $fp = fopen($filename, 'rb');
    if ($fp) {
        flock($fp, LOCK_SH);
        clearstatcache();
        $filesize = filesize($filename);
        if ($filesize > 0) {
            $data = fread($fp, $filesize);
        } else {
            $data = false;
        }
        flock($fp, LOCK_UN);
        fclose($fp);
        return $data;
    } else {
        return false;
    }
}

if (!function_exists('file_put_contents'))
{
    function file_put_contents($filename, & $content)
    {
        return safe_file_put_contents($filename, $content);
    }
}

/**
 * ���Ժʹ�������ص�ȫ�ֺ���
 */

/**
 * �׳�һ���쳣
 *
 * FleaPHP Ϊ�˼��� PHP4��ģ����һ���쳣���ơ�������ģ����ƺ��������쳣�����б�������
 * FleaPHP ģ����쳣�����������ص㣺
 *   - �� __TRY() ������ try ���ò���㣻
 *   - �� __CATCH() �����쳣�������� catch��
 *   - �� __THROW() �׳��쳣��
 *   - __TRY() �� __CATCH() �����ܹ����� PHP5 ���� throw �׳����쳣��
 *   - ������ʹ�� __THROW() �׳��쳣�󣬱���ʹ�� return false �˳��������෽����ִ�У�
 *   - __TRY() �� __CATCH() ����ɶԵ��ã����� __CATCH() ֻ�ܲ���һ���쳣��
 *   - �� __IS_EXCEPTION() ���ж� __CATCH() �ķ���ֵ�Ƿ���һ���쳣��
 *   - ��� __TRY() ���ú�û���� __CATCH() �����쳣�������� __CANCEL_TRY() ȡ������
 *
 * ��Ȼ __THROW() ����ǿ��Ҫ���׳����쳣�����Ǵ� FLEA_Exception �̳е��࣬��Ӧ�ó���
 * Ӧ���׳� FleaPHP �Ѿ�������쳣�����ߴ� FLEA_Exception ����Ӧ�ó����Լ����쳣��
 * FLEA_Exception �ṩ��һЩ������������Ӧ�ó�����õĴ����쳣��
 *
 * ����Ĵ���Ƭ����ģ���쳣�����ʹ����ʽ��
 * <code>
 * __TRY();
 * $ret = doSomething(); // ���ÿ��ܻᷢ���쳣�Ĵ���
 * $ex = __CATCH();
 * if (__IS_EXCEPTION($ex)) {
 *     // �����쳣
 * } else {
 *     echo $ret;
 * }
 *
 * function doSomething() {
 *     if (rand(0, 9) % 2) {
 *         __THROW(new MyException());
 *         return false;
 *     }
 *     return true;
 * }
 * </code>
 *
 * <strong>�ر�Ҫע��ľ���ʹ�� __THROW() �׳��쳣�󣬱��� return false</strong>
 *
 * ���� doSomething() �е� __THROW() ʵ���ϲ����жϳ���ִ�У����Ե��� doSomething() ��
 * ����Ҫ�����鷵��ֵ�������ڵ��� doSomething() �Ժ���Ⲷ���쳣��
 *
 * Ϊ�ˣ�__TRY() �� __CATCH() ֮��Ĵ���Ҫ�����ܵ��١�
 *
 * <strong>���� __TRY() �� __CATCH() ��Ƕ�����⣺</strong>
 *
 * FleaPHP ������ __TRY() Ƕ�׵ġ���������������У�doSomething() �������������������׳�
 * �쳣�Ĵ��롣���� doSomething() ��Ҳ����ͨ�� __TRY() �� __CATCH() �������쳣��
 *
 * <code>
 * function doSomething() {
 *     if (rand(0, 9) % 2) {
 *         __THROW(new MyException());
 *         return false;
 *     } else {
 *         __TRY();
 *         callAnotherFunc();
 *         $ex = __CATCH();
 *         if (__IS_EXCEPTION($ex)) {
 *             // ���� callAnotherFunc() �����׳����쳣
 *             ...
 *             // ���ݴ������������� __THROW() �����׳�����쳣��
 *             // �õ��� doSomething() �Ĵ���ȥ������쳣
 *             __THROW($ex);
 *             return false;
 *         }
 *         return true;
 *     }
 * }
 * </code>
 *
 * ������� __TRY() ֮����Ҫ���� __CATCH() �����쳣��������� __CANCEL_TRY()
 * ������ __TRY() ���õĲ���㡣
 *
 * @package Core
 *
 * @param FLEA_Exception $exception
 *
 * @return boolean
 */
function __THROW($exception)
{
    // д����־
    if (function_exists('log_message')) {
        log_message(get_class($exception) . ': ' . $exception->getMessage(), 'exception');
    }

    // ȷ���Ƿ��쳣������ջ��
    if (isset($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK']) && is_array($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK']))
    {
        $point = array_pop($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK']);
        if ($point != null) {
            array_push($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK'], $exception);
            $ret = false;
            return $ret;
        }
    }

    if (isset($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_HANDLER'])) {
        call_user_func_array($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_HANDLER'], array(& $exception));
    } else {
        __FLEA_EXCEPTION_HANDLER($exception);
    }
    exit;
}

/**
 * �����쳣���ص�
 *
 * @package Core
 */
function __TRY()
{
    static $point = 0;
    if (!isset($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK']) ||
        !is_array($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK']))
    {
        $GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK'] = array();
    }

    $point++;
    array_push($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK'], $point);
}

/**
 * �����׳����쳣�����û���쳣�׳������� false
 *
 * @package Core
 *
 * @return FLEA_Exception
 */
function __CATCH()
{
    if (!is_array($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK'])) {
        return false;
    }
    $exception = array_pop($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK']);
    if (!is_object($exception)) {
        $exception = false;
    }
    return $exception;
}

/**
 * ������һ�� __TRY() �쳣��������
 *
 * @package Core
 */
function __CANCEL_TRY()
{
    if (is_array($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK'])) {
        array_pop($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_STACK']);
    }
}

/**
 * �ж��Ƿ���һ���쳣
 *
 * $type ���������ж��쳣�Ƿ���ָ�������͡�
 *
 * @package Core
 *
 * @param FLEA_Exception $exception
 * @param string $type
 */
function __IS_EXCEPTION($exception, $type = null)
{
    if (!is_object($exception) || !is_a($exception, 'FLEA_Exception')) {
        return false;
    }
    if (is_null($type)) {
        return true;
    } else {
        return strtoupper($type) == strtoupper(get_class($exception));
    }
}

/**
 * �����µ��쳣�������̣����ص�ǰʹ�õ��쳣��������
 *
 * ���׳����쳣û���κ� __TRY() ����ʱ���������쳣�������̡�FleaPHP Ĭ�ϵ�
 * �쳣�������̻���ʾ�쳣����ϸ��Ϣ���Ѿ���������·�������������߶�λ����
 *
 * �÷���
 * <code>
 * // ��������ʹ�õ��쳣��������
 * global $prevExceptionHandler;
 * $prevExceptionHandler = __SET_EXCEPTION_HANDLER('app_exception_handler');
 *
 * function app_exception_handler(& $ex) {
 *     global $prevExceptionHandler;
 *
 *     if (is_a($ex, 'APP_Exception')) {
 *        // ������쳣
 *        ...
 *     } else {
 *        // ����ԭ�е��쳣��������
 *        if ($prevExceptionHandler) {
 *            call_user_func_array($prevExceptionHandler, array(& $exception));
 *        }
 *     }
 * }
 * </code>
 *
 * ����Ĵ���������һ���µ��쳣�������̣�ͬʱ�����ڱ�Ҫʱ����ԭ�е��쳣�������̡�
 * ��Ȼ��ǿ��Ҫ�󿪷���������������������Ĵ���Ƭ�ο����γ�һ���쳣�������̵�������
 *
 * @package Core
 *
 * @param callback $callback
 *
 * @return mixed
 */
function __SET_EXCEPTION_HANDLER($callback)
{
    if (isset($GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_HANDLER'])) {
        $current = $GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_HANDLER'];
    } else {
        $current = null;
    }
    $GLOBALS[G_FLEA_VAR]['FLEA_EXCEPTION_HANDLER'] = $callback;
    return $current;
}

/**
 * FleaPHP Ĭ�ϵ��쳣��������
 *
 * @package Core
 *
 * @param FLEA_Exception $ex
 */
function __FLEA_EXCEPTION_HANDLER($ex)
{
    if (!FLEA::getAppInf('displayErrors')) { exit; }
    if (FLEA::getAppInf('friendlyErrorsMessage')) {
        $language = FLEA::getAppInf('defaultLanguage');
        $language = preg_replace('/[^a-z0-9\-_]+/i', '', $language);

        $exclass = strtoupper(get_class($ex));
        $template = FLEA_DIR . "/_Errors/{$language}/{$exclass}.php";
        if (!file_exists($template)) {
            $template = FLEA_DIR . "/_Errors/{$language}/FLEA_EXCEPTION.php";
            if (!file_exists($template)) {
                $template = FLEA_DIR . "/_Errors/default/FLEA_EXCEPTION.php";
            }
        }
        include($template);
    } else {
        print_ex($ex);
    }
    exit;
}

/**
 * ��ӡ�쳣����ϸ��Ϣ
 *
 * @package Core
 *
 * @param FLEA_Exception $ex
 * @param boolean $return Ϊ true ʱ���������Ϣ��������ֱ����ʾ
 */
function print_ex($ex, $return = false)
{
    $out = "exception '" . get_class($ex) . "'";
    if ($ex->getMessage() != '') {
        $out .= " with message '" . $ex->getMessage() . "'";
    }
    if (defined('DEPLOY_MODE') && DEPLOY_MODE != false) {
        $out .= ' in ' . basename($ex->getFile()) . ':' . $ex->getLine() . "\n\n";
    } else {
        $out .= ' in ' . $ex->getFile() . ':' . $ex->getLine() . "\n\n";
        $out .= $ex->getTraceAsString();
    }

    if ($return) { return $out; }

    if (ini_get('html_errors')) {
        echo nl2br(htmlspecialchars($out));
    } else {
        echo $out;
    }

    return '';
}

/**
 * ������������ݣ�ͨ�����ڵ���
 *
 * @package Core
 *
 * @param mixed $vars Ҫ����ı���
 * @param string $label
 * @param boolean $return
 */
function dump($vars, $label = '', $return = false)
{
    if (ini_get('html_errors')) {
        $content = "<pre>\n";
        if ($label != '') {
            $content .= "<strong>{$label} :</strong>\n";
        }
        $content .= htmlspecialchars(print_r($vars, true));
        $content .= "\n</pre>\n";
    } else {
        $content = $label . " :\n" . print_r($vars, true);
    }
    if ($return) { return $content; }
    echo $content;
    return null;
}

/**
 * ��ʾӦ�ó���ִ��·����ͨ�����ڵ���
 *
 * @package Core
 *
 * @return string
 */
function dump_trace()
{
    $debug = debug_backtrace();
    $lines = '';
    $index = 0;
    for ($i = 0; $i < count($debug); $i++) {
        if ($i == 0) { continue; }
        $file = $debug[$i];
        if ($file['file'] == '') { continue; }
        if (substr($file['file'], 0, strlen(FLEA_DIR)) != FLEA_DIR) {
            $line = "#<strong>{$index} {$file['file']}({$file['line']}): </strong>";
        } else {
            $line = "#{$index} {$file['file']}({$file['line']}): ";
        }
        if (isset($file['class'])) {
            $line .= "{$file['class']}{$file['type']}";
        }
        $line .= "{$file['function']}(";
        if (isset($file['args']) && count($file['args'])) {
            foreach ($file['args'] as $arg) {
                $line .= gettype($arg) . ', ';
            }
            $line = substr($line, 0, -2);
        }
        $line .= ')';
        $lines .= $line . "\n";
        $index++;
    } // for
    $lines .= "#{$index} {main}\n";

    if (ini_get('html_errors')) {
        echo nl2br(str_replace(' ', '&nbsp;', $lines));
    } else {
        echo $lines;
    }
}

/**
 * ��ȡ��ǰ����������������ʽ��
 *
 * @param mixed $time
 *
 * @return float
 */
function microtime_float($time = null)
{
    list($usec, $sec) = explode(' ', $time ? $time : microtime());
    return ((float)$usec + (float)$sec);
}

/**
 * ��ѯָ��������Ϣ��Ӧ����Ϣ�ı�
 *
 * �ú��������Ӧ�ó������� 'defaultLanguage' ���벻ͬ���ԵĴ�����Ϣ�ļ���
 * Ȼ����ݴ�������ѯ������Ϣ�ı��������ز�ѯ�����
 *
 * ע�⣬����Ҳ���ָ�����ԵĴ�����Ϣ����������Ϊ default �������ļ���
 *
 * �� $appError Ϊ true ʱ��_ET() �᳢����Ӧ�ó�������
 * 'languageFilesDir' ָ����Ŀ¼�ж�ȡ�����ļ���
 *
 * @package Core
 *
 * @param int $errorCode
 * @param boolean $appError
 *
 * @return string
 */
function _ET($errorCode, $appError = false)
{
    static $message = array();

    $language = FLEA::getAppInf('defaultLanguage');
    $language = preg_replace('/[^a-z0-9\-_]+/i', '', $language);

    if (!isset($message[$language])) {
        if ($appError) {
            $filename = FLEA::getAppInf('languageFilesDir') . DS .
                $language . DS . 'ErrorMessage.php';
        } else {
            // ��ȡ FleaPHP �Դ��Ĵ�����Ϣ�б�
            $filename = FLEA_DIR . "/_Errors/{$language}/ErrorMessage.php";
        }
        if (!is_readable($filename)) {
            $filename = FLEA_DIR . '/_Errors/default/ErrorMessage.php';
        }
        $message[$language] = include($filename);
    }

    return isset($message[$language][$errorCode]) ?
        $message[$language][$errorCode] :
        '';
}

/**
 * PHP4 �� PHP5 ʹ�ò�ͬ���ඨ��
 */
if (PHP5) {

    class FLEA_Exception extends Exception
    {
        function FLEA_Exception($message = '', $code = 0)
        {
            parent::__construct($message, $code);
        }
    }

} else {

    /**
     * FLEA_Exception ���װ��һ���쳣
     *
     * �� PHP5 �У�FLEA_Exception �̳��� PHP ���õ� Exception �ࡣ
     * �� PHP4 �У���ģ�����쳣���ơ�
     *
     * @package Exception
     * @author ��Դ�Ƽ� (www.qeeyuan.com)
     * @version 1.0
     */
    class FLEA_Exception
    {
        /**
         * �쳣��Ϣ
         *
         * @var string
         */
        var $message = 'Unknown exception';

        /**
         * �������
         */
        var $code = 0;

        /**
         * �׳��쳣���ļ�
         *
         * @var string
         */
        var $file;

        /**
         * �׳��쳣������к�
         *
         * @var int
         */
        var $line;

        /**
         * ���ö�ջ
         *
         * @var array
         */
        var $trac;

        /**
         * ���캯��
         *
         * @param string $message
         * @param int $code
         *
         * @return FLEA_Exception
         */
        function FLEA_Exception($message = null, $code = 0)
        {
            $this->message = $message;
            $this->code = $code;
            $this->trac = debug_backtrace();

            // ȡ���׳��쳣���ļ��ʹ����к�
            $last = array_shift($this->trac);
            $this->file = $last['file'];
            $this->line = $last['line'];
        }

        /**
         * ����쳣������Ϣ
         *
         * @return string
         */
        function getMessage()
        {
            return $this->message;
        }

        /**
         * ����쳣�������
         *
         * @return int
         */
        function getCode()
        {
            return $this->code;
        }

        /**
         * ����׳��쳣���ļ���
         *
         * @return string
         */
        function getFile()
        {
            return $this->file;
        }

        /**
         * ����׳��쳣�Ĵ����к�
         *
         * @return int
         */
        function getLine()
        {
            return $this->line;
        }

        /**
         * ���ص��ö�ջ
         *
         * @return array
         */
        function getTrace()
        {
            return $this->trac;
        }

        /**
         * �����ַ�����ʾ�ĵ��ö�ջ
         */
        function getTraceAsString()
        {
            $out = '';
            $ix = 0;
            foreach ($this->trac as $point) {
                $out .= "#{$ix} {$point['file']}({$point['line']}): {$point['function']}(";
                if (is_array($point['args']) && count($point['args']) > 0) {
                    foreach ($point['args'] as $arg) {
                        switch (gettype($arg)) {
                        case 'array':
                        case 'resource':
                            $out .= gettype($arg);
                            break;
                        case 'object':
                            $out .= get_class($arg);
                            break;
                        case 'string':
                            if (strlen($arg) > 30) {
                                $arg = substr($arg, 0, 27) . ' ...';
                            }
                            $out .= "'{$arg}'";
                            break;
                        default:
                            $out .= $arg;
                        }
                        $out .= ', ';
                    }
                    $out = substr($out, 0, -2);
                }
                $out .= ")\n";
                $ix++;
            }
            $out .= "#{$ix} {main}\n";

            return $out;
        }

        /**
         * �����쳣���ַ�����ʽ
         *
         * @return string
         */
        function __toString()
        {
            $out = "exception '" . get_class($this) . "'";
            if ($this->message != '') {
                $out .= " with message '{$this->message}'";
            }
            $out .= " in {$this->file}:{$this->line}\n\n";
            $out .= $this->getTraceAsString();
            return $out;
        }
    }

}

/**
 * Ajax ��صĺ���
 */
 /**
 * ��û���ҵ� PHP ���õ� JSON ��չʱ��ʹ�� PEAR::Service_JSON ������ JSON �Ĺ���ͽ���
 *
 * ǿ���Ƽ����� PHP �û���װ JSON ��չ�������õ����ܱ��֡�
 */

if (!function_exists('json_encode')) {
    /**
     * ������ת��Ϊ JSON �ַ���
     *
     * @param mixed $value
     *
     * @return string
     */
    function json_encode($value)
    {
        static $instance = array();
        if (!isset($instance[0])) {
            require_once(FLEA_DIR . '/Ajax/JSON.php');
            $instance[0] =& new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
        }
        return $instance[0]->encode($value);
    }
}

if (!function_exists('json_decode')) {
    /**
     * �� JSON �ַ���ת��Ϊ����
     *
     * @param string $jsonString
     *
     * @return mixed
     */
    function json_decode($jsonString)
    {
        static $instance = array();
        if (!isset($instance[0])) {
            require_once(FLEA_DIR . '/Ajax/JSON.php');
            $instance[0] =& new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
        }
        return $instance[0]->decode($jsonString);
    }
}
