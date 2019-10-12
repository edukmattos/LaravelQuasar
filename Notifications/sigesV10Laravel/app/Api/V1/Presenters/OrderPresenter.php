<?php

namespace App\Api\V1\Presenters;

use App\Api\V1\Transformers\OrderTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OrderPresenter.
 *
 * @package namespace App\Api\V1\Presenters;
 */
class OrderPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OrderTransformer();
    }
}
