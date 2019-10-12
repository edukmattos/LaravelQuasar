<?php

namespace App\Api\V1\Presenters;

use App\Api\V1\Transformers\ClientStatusTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ClientStatusPresenter.
 *
 * @package namespace App\Api\V1\Presenters;
 */
class ClientStatusPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ClientStatusTransformer();
    }
}
