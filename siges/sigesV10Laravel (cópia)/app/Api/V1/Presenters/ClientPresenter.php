<?php

namespace App\Api\V1\Presenters;

use App\Api\V1\Transformers\ClientTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ClientPresenter.
 *
 * @package namespace App\Api\V1\Presenters;
 */
class ClientPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ClientTransformer();
    }
}
