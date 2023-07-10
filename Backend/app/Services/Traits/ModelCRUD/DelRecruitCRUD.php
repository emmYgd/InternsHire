<?php

namespace App\Services\Traits\ModelCRUD;

use App\Models\DelegateRecruitment;

use Illuminate\Http\Request;

trait DelRecruitCRUD
{
	//CRUD for services:
	protected function DelRecruitCreateAllService($anyParams): bool
	{
		$detailsSaved = DelegateRecruitment::create($anyParams);
		return true;		
	}


	protected function DelRecruitReadSpecificService(array $queryKeysValues): array
	{	
		$readModel = DelegateRecruitment::where($queryKeysValues)->first();
		return $readModel;
	}


	protected function DelRecruitReadAllService(array $queryKeysValues): array
	{
		$readAllModel = DelegateRecruitment::get();
		return $readAllModel;
	}


	protected function DelRecruitReadSpecificAllService(array $queryKeysValues): array
	{
		$readSpecificAllModel = DelegateRecruitment::where($queryKeysValues)->get();
		return $readAllModel;
	}


	protected function DelRecruitUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool
	{
		DelegateRecruitment::where($queryKeysValues)->update($newKeysValues);
		return true;
	}

	protected function DelRecruitDeleteSpecificService(array $deleteKeysValues): bool
	{
		DelegateRecruitment::where($deleteKeysValues)->delete();
		return true;
	}

}

?>