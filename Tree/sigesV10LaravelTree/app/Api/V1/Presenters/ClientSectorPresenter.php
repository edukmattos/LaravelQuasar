<?php

namespace App\Api\V1\Presenters;

use App\Api\V1\Transformers\ClientSectorTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ClientSectorPresenter.
 *
 * @package namespace App\Api\V1\Presenters;
 */
class ClientSectorPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ClientSectorTransformer();
    }
}
