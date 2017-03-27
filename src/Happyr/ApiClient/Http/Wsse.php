<?php

namespace Happyr\ApiClient\Http;

/**
 * Class Wsse.
 *
 * Handle the Wsse Security headers
 */
class Wsse
{
    protected $username;
    protected $password;
    protected $digest;
    protected $nonce;
    protected $created;
    protected $profile = 'UsernameToken';

    /**
     * @param string $username
     * @param string $password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;

        $this->build();
    }

    /**
     * Build the headers.
     */
    protected function build()
    {
        $this->created = gmdate('Y-m-d\TH:i:s\Z');
        $this->nonce = $this->getRandomString();

        // calculate the digest
        $this->digest = base64_encode(sha1(base64_decode($this->nonce).$this->created.$this->password, true));
    }

    /**
     * Returns the headers.
     *
     *
     * @return array
     */
    public function getHeaders()
    {
        return array(
            'Authorization' => sprintf('WSSE profile="%s"', $this->profile),
            'X-WSSE' => sprintf('%s Username="%s", PasswordDigest="%s", Nonce="%s", Created="%s"', $this->profile, $this->username, $this->digest, $this->nonce, $this->created),
        );
    }

    /**
     * Return a random string.
     * This must be a good non-guessable random string.
     *
     *
     * @return string
     */
    protected function getRandomString()
    {
        $length = mt_rand(8, 16);
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charlen = strlen($characters);

        $randomString = '';
        for ($i = 0; $i < $length; ++$i) {
            $randomString .= $characters[mt_rand(0, $charlen - 1)];
        }

        return $randomString;
    }
}
