<?php

namespace App\Services\Traits\ModelCRUD;

use App\Models\Chat;

use Illuminate\Http\Request;

trait ChatCRUD
{
	//CRUD for services:
	protected function ChatCreateAllService($anyParam): bool
	{
		Chat::create($validatedRequest);
		return true;		
	}


	protected function ChatReadSpecificService(array $queryKeysValues): array
	{	
		$readModel = Chat::where($queryKeysValues)->first();
		return $readModel;
	}


	protected function ChatReadAllService(array $queryKeysValues): array
	{
		$readAllModel = Chat::get();
		return $readAllModel;
	}


	protected function ChatReadSpecificAllService(array $queryKeysValues): array
	{
		$readSpecificAllModel = Chat::where($queryKeysValues)->get();
		return $readAllModel;
	}


	protected function ChatUpdateSpecificService(array $queryKeysValues, array $newKeysValues): bool
	{
		Chat::where($queryKeysValues)->update($newKeysValues);
		return true;
	}

	protected function ChatDeleteSpecificService(array $deleteKeysValues): bool
	{
		Chat::where($deleteKeysValues)->delete();
		return true;
	}
	

}

?>