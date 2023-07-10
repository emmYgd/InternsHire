<?php

namespace App\Services\Traits\ModelCRUD;

use App\Models\CommentRate;

use Illuminate\Http\Request;

trait CommentRateCRUD
{
	//CRUD for services:
	protected function CommentRateCreateAllService($anyParams):bool
	{
		CommentRate::create($anyParams);
		return true;		
	}


	protected function CommentRateReadSpecificService(array $queryKeysValues): array
	{	
		$readModel = CommentRate::where($queryKeysValues)->first();
		return $readModel;
	}


	/*protected function CommentRateReadAllService(): array 
	{
		$readAllModel = CommentRate::get();
		return $readAllModel;
	}*/

	protected function CommentRateReadAllLazyService(array $queryKeysValues): array 
	{
		$readAllModel = CommentRate::where($queryKeysValues)->lazy()->orderByDesc('rating');
		return $readAllModel;
	}
	

	protected function CommentRateReadSpecificAllService(array $queryKeysValues): array 
	{
		$readSpecificAllModel = CommentRate::where($queryKeysValues)->get();
		return $readAllModel;
	}


	protected function CommentRateUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool 
	{
		CommentRate::where($queryKeysValues)->update($newKeysValues);
		return true;
	}

	protected function CommentRateDeleteSpecificService(array $deleteKeysValues): bool
	{
		CommentRate::where($deleteKeysValues)->delete();
		return true;
	}

}

?>