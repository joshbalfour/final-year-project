<?php
/**
 * Created by PhpStorm.
 * User: ryan
 * Date: 03/11/15
 * Time: 14:43
 */

namespace App\Commands;

use League\Flysystem\Adapter\AbstractFtpAdapter;
use League\Flysystem\Config;

class MockFtpAdapter extends AbstractFtpAdapter
{

    private $isConnected = false;

    private $contents = [];

    /**
     * MockFtpAdapter constructor.
     */
    public function __construct()
    {
    }

    public function listContents($directory = '', $recursive = false)
    {
        $filenames = [];
        foreach ($this->contents as $filename => $_unusedcontents) {
            $filenames[] = $filename;
        }
        return $filenames;
    }

    /**
     * Establish a connection.
     */
    public function connect()
    {
        $this->isConnected = true;
    }

    /**
     * Close the connection.
     */
    public function disconnect()
    {
        $this->isConnected = false;
    }

    /**
     * Check if a connection is active.
     *
     * @return bool
     */
    public function isConnected()
    {
        return $this->isConnected;
    }

    /**
     * Write a new file.
     *
     * @param string $path
     * @param string $contents
     * @param Config $config Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function write($path, $contents, Config $config)
    {
        return false; // No need to write
    }

    /**
     * Write a new file using a stream.
     *
     * @param string $path
     * @param resource $resource
     * @param Config $config Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function writeStream($path, $resource, Config $config)
    {
        return false; // No need to write
    }

    /**
     * Update a file.
     *
     * @param string $path
     * @param string $contents
     * @param Config $config Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function update($path, $contents, Config $config)
    {
        // No need to write
    }

    /**
     * Update a file using a stream.
     *
     * @param string $path
     * @param resource $resource
     * @param Config $config Config object
     *
     * @return array|false false on failure file meta data on success
     */
    public function updateStream($path, $resource, Config $config)
    {
        return false; // No need to write
    }

    /**
     * Rename a file.
     *
     * @param string $path
     * @param string $newpath
     *
     * @return bool
     */
    public function rename($path, $newpath)
    {
        return false; // No need to write
    }

    /**
     * Copy a file.
     *
     * @param string $path
     * @param string $newpath
     *
     * @return bool
     */
    public function copy($path, $newpath)
    {
        return false; // No need to write
    }

    /**
     * Delete a file.
     *
     * @param string $path
     *
     * @return bool
     */
    public function delete($path)
    {
        return false; // No need to write
    }

    /**
     * Delete a directory.
     *
     * @param string $dirname
     *
     * @return bool
     */
    public function deleteDir($dirname)
    {
        return false; // No need to write
    }

    /**
     * Create a directory.
     *
     * @param string $dirname directory name
     * @param Config $config
     *
     * @return array|false
     */
    public function createDir($dirname, Config $config)
    {
        return false; // No need to write
    }

    /**
     * Set the visibility for a file.
     *
     * @param string $path
     * @param string $visibility
     *
     * @return array|false file meta data
     */
    public function setVisibility($path, $visibility)
    {
        return false; // No need to write
    }

    /**
     * Read a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function read($path)
    {
        return [ 'contents' => $this->contents[$path] ];
    }

    /**
     * Read a file as a stream.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function readStream($path)
    {
        return false; // No need to read as stream
    }

    /**
     * Get all the meta data of a file or directory.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getMetadata($path)
    {
        return false; // Not needed
    }

    /**
     * Get the mimetype of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getMimetype($path)
    {
        return false; // Not needed
    }

    /**
     * Get the timestamp of a file.
     *
     * @param string $path
     *
     * @return array|false
     */
    public function getTimestamp($path)
    {
        return false; // Not needed
    }

    public function setContents( $files )
    {
        foreach ( $files as $filename => $contents ){
            $this->contents[$filename] = $contents;
        }
    }
}