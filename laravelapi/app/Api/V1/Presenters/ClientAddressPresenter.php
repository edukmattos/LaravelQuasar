<?php

namespace App\Api\V1\Presenters;

use App\Api\V1\Transformers\ClientAddressTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ClientAddressPresenter.
 *
 * @package namespace App\Api\V1\Presenters;
 */
class ClientAddressPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ClientAddressTransformer();
    }
}
