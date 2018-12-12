<?php
/**
 * User Resource
 */
namespace Twigger\UnionCloud\Resource;

use Twigger\UnionCloud\Exception\Resource\ResourceNotFoundException;
use Twigger\UnionCloud\ResourceCollection;

/**
 * Class User
 *
 * @package Twigger\UnionCloud\Users\Users
 *
 * @property int $id ID of the user. Not quite sure what this is!
 * @property int $uid UID of the user.
 * @property string $forename User Forename
 * @property string $surname User Surname
 * @property string $email User Email
 * @property int $unionId Union ID
 * @property string $unionName Union Name
 * @property string $organisationName Organization Name
 * @property string $studentId Student ID
 * @property string $dob Date of Birth
 * @property string $gender Gender
 * @property string $institution_email Institution Email
 * @property string $nationality Nationality
 * @property string $domicileCountry Domicile Country
 * @property string $feeStatus Fee Status
 * @property string $hallOfResidence Hall of Residence
 * @property string $programme Programme
 * @property string $courseFinishingYear Course Finishing Year
 * @property string $alternateEmailAddr Alternate Email Address
 * @property boolean $isUploaded Is Uploaded?
 * @property string $userType User Type
 * @property string $isAlumni Is Alumni?
 * @property string $libraryCard Library Card
 * @property string $department Department
 * @property string $erasmus Erasmus
 * @property string $placement Placement
 * @property string $ethnicity Ethnicity
 * @property string $finalist Finalist
 * @property string $modeOfStudy Mode of Study
 * @property string $address Address
 * @property string $postcode Postcode
 * @property string $unionCommunication Union Communication
 * @property string $unionCommercial Union Commercial
 * @property string $nusCommunication NUS Communication
 * @property string $nusCommercial NUS Commercial
 * @property string $termsAndConditions Terms and COnditions
 * @property string $updatedAt Updated At
 * @property string $additionalIdentities Additional Identities
 * @property ResourceCollection $userGroupMemberships User Group Memberships
 *
 */
class User extends BaseResource implements IResource
{

    /**
     * Enable casting for this resource
     *
     * @var array
     */
    protected $casts = [
        'dob' => 'date',
        'courseFinishingYear' => 'date',
        'updatedAt' => 'date',
        'forename' => 'properCase',
        'surname' => 'properCase',
        'userGroupMemberships' => UserGroupMembership::class,
    ];
    /**
     * Set the model parameters
     *
     * User constructor.
     *
     * @param $resource
     *
     * @throws ResourceNotFoundException
     */
    public function __construct($resource)
    {
        parent::__construct($resource);

    }
}