<?php
/**
 * Election Category Request class
 */
namespace Twigger\UnionCloud\API\Request;


use Twigger\UnionCloud\API\Auth\Authentication;
use Twigger\UnionCloud\API\Configuration;
use Twigger\UnionCloud\API\Response\ElectionCategoryResponse;

/**
 * Class Election Category Request
 *
 * @package Twigger\UnionCloud\API\Elections\ElectionCategories
 *
 * @license    https://opensource.org/licenses/GPL-3.0  GNU Public License v3
 *
 * @author     Toby Twigger <tt15951@bristol.ac.uk>
 *
 */
class ElectionCategoryRequest extends BaseRequest implements IRequest
{
    /**
     * Election Category Request constructor.
     *
     * @param Authentication $authentication
     * @param Configuration $configuration
     */
    public function __construct($authentication, $configuration)
    {
        parent::__construct($authentication, $configuration, ElectionCategoryResponse::class);
    }


    /**
     * Gets the current instance
     *
     * @return $this
     *
     */
    public function getInstance()
    {
        return $this;
    }



    /*
    |--------------------------------------------------------------------------
    | API Endpoint Definitions
    |--------------------------------------------------------------------------
    |
    | Define your API endpoints below here
    |
    */


    /**
     * Get all election categories
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function getAll()
    {
        $this->setAPIParameters(
            'election_categories',
            'GET'
        );

        $this->enablePagination();
        $this->enableTimes();

        $this->call();

        return $this->getReturnDetails();
    }

    /**
     * Get a specific election category
     *
     * @param integer $categoryID ID of the election category
     *
     * @return $this|\Twigger\UnionCloud\API\Response\IResponse|\Twigger\UnionCloud\API\ResourceCollection
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Twigger\UnionCloud\API\Exception\Request\RequestHistoryNotFound
     * @throws \Twigger\UnionCloud\API\Exception\Response\BaseResponseException
     */
    public function getByID($categoryID)
    {
        $this->setAPIParameters(
            'election_categories/'.$categoryID,
            'GET'
        );

        $this->call();

        return $this->getReturnDetails();
    }

}