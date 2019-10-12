<?php

namespace App\Api\V1\Presenters;

use App\Api\V1\Transformers\ClientLocationTypeTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ClientLocationTypePresenter.
 *
 * @package namespace App\Api\V1\Presenters;
 */
class ClientLocationTypePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ClientLocationTypeTransformer();
    }
}
