<?php

namespace controller;

class Program
{
    /* @var $memberView \view\Member */
    private $memberView;

    /* @var $boatView \view\Boat */
    private $boatView;

    /* @var $navView \view\NavigationView */
    private $navView;

    /* @var $navView \model\dal\MemberRepository */
    private $memberRepository;

    /* @var $navView \model\dal\BoatRepository */
    private $boatRepository;

    public function RunAction()
    {
        switch($this->navView->GetAction()){
            case \view\NavigationView::ViewAllVerbose :
                return $this->navView->GetBackLink() . $this->memberView->ViewAllVerbose();
                break;
            case \view\NavigationView::ViewAll :
                return $this->navView->GetBackLink() . $this->memberView->ViewAll();
                break;
            case \view\NavigationView::ViewMember :
                return $this->navView->GetBackLink() . $this->memberView->ViewMember();
                break;
            case \view\NavigationView::EditMember :
                return $this->navView->GetBackLink() . $this->EditMember();
                break;
            case \view\NavigationView::AddMember :
                return $this->navView->GetBackLink() . $this->AddMember();
                break;
            case \view\NavigationView::DeleteMember :
                return $this->navView->GetBackLink() . $this->DeleteMember();
                break;
            case \view\NavigationView::EditBoat :
                return $this->navView->GetBackLink() . $this->EditBoat();
                break;
            case \view\NavigationView::AddBoat :
                return $this->navView->GetBackLink() . $this->AddBoat();
                break;
            case \view\NavigationView::DeleteBoat :
                return $this->navView->GetBackLink() . $this->DeleteBoat();
                break;
            default:
                return $this->navView->ShowInstructions();
                break;
        }
    }

    public function Main(){
        $this->memberRepository = new \model\dal\MemberRepository();
        $this->boatRepository = new \model\dal\BoatRepository();
        $this->navView = new \view\NavigationView();
        $this->boatView = new \view\Boat($this->navView);
        $this->memberView = new \view\Member($this->memberRepository, $this->navView, $this->boatView);

        return $this->RunAction();
    }

    /* Use case methods goes here */

    //Member methods
    public function EditMember(){
        if($this->memberView->HasEditedMember()){
            $updatedMember = $this->memberView->GetUpdatedMember();
            $this->memberRepository->Save($updatedMember);

            return $this->memberView->UpdateSuccess();
        }else{
            return $this->memberView->EditMember();
        }
    }

    public function AddMember(){
        if($this->memberView->HasAddedMember()){
            $newMember = $this->memberView->GetNewMember();
            $this->memberRepository->Save($newMember);

            return $this->memberView->AddedSuccess();
        }else{
            return $this->memberView->AddMember();
        }
    }

    public function DeleteMember(){
        if($this->memberView->WantsToDeleteMember()){
            $deleteMember = $this->memberView->GetMemberToDelete();
            $this->memberRepository->Delete($deleteMember);

            return $this->memberView->DeletedSuccess();
        }else{
            return $this->memberView->DeleteMember();
        }
    }

    //Boat methods
    // TODO: Good solution?
    public function EditBoat(){
        if($this->boatView->HasEditedBoat()){
            $updatedBoatID = $this->boatView->GetUpdatedBoatID();
            $updatedBoat = $this->boatRepository->GetBoatById($updatedBoatID);

            $updatedBoat->SetType($this->boatView->GetPostType());
            $updatedBoat->SetLength($this->boatView->GetPostLength());

            $this->boatRepository->Save($updatedBoat);

            return $this->boatView->UpdateSuccess();
        }else{
            return $this->boatView->EditBoat();
        }
    }

    public function AddBoat(){
        if($this->boatView->HasAddedBoat()){
            $newBoat = $this->boatView->GetNewBoat();
            $this->boatRepository->Save($newBoat);
            return $this->boatView->AddedSuccess();
        }else{
            return $this->boatView->AddBoat();
        }
    }

    public function DeleteBoat(){
        if($this->boatView->WantsToDeleteBoat()){
            $deleteBoat = $this->boatView->GetBoatToDelete();
            $this->boatRepository->Delete($deleteBoat);

            return $this->boatView->DeletedSuccess();
        }else{
            return $this->boatView->DeleteBoat();
        }
    }

}
