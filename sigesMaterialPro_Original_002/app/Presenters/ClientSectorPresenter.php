<?php

namespace App\Presenters;

use App\Transformers\ClientSectorTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ClientSectorPresenter.
 *
 * @package namespace App\Presenters;
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
