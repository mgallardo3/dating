<?php
/**
 * Class Public Member represents a member with a premium membership in the dating site
 *
 * The Public Member represents a member from the dating site who has a premium
 * membership
 *
 * @author Maria Gallardo <mgallardo3@mail.greenriver.edu>
 * @copyright 2019
 */
class PremiumMember extends Member
{
    private $_inDoorInterests;
    private $_outDoorInterests;

    /**
     * Returns the Member's indoor interests
     * @return string[], $_inDoorInterests returns the indoor interest
     */
    public function getInDoorInterests()
    {
        return $this->_inDoorInterests;
    }

    /**
     * Sets the Member's  indoor interests
     * @param string[] $inDoorInterests, contains indoor interests
     * @return void
     */
    public function setInDoorInterests($inDoorInterests)
    {
        $this->_inDoorInterests = $inDoorInterests;
    }

    /**
     * Returns the Member's outdoor interests
     * @return string[], $_outDoorInterests returns the indoor interest
     */
    public function getOutDoorInterests()
    {
        return $this->_outDoorInterests;
    }

    /**
     * Sets the Member's  outdoor interests
     * @param string[] $outDoorInterests, contains outdoor interests
     * @return void
     */
    public function setOutDoorInterests($outDoorInterests)
    {
        $this->_outDoorInterests = $outDoorInterests;
    }

}