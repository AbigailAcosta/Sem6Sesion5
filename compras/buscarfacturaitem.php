<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="agregarConcepto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-edit"></i> Agregando artículos</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div class="form-group row">
                        <label for="" class="control-label col-md-2">Articulo</label>
                        <div class="col-md-8">
                            <input class="form-control" type="text" name="q" id="q" placeholder="teclee para buscar">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary" onclick="load(1);">
                                <span class="fa fa-search"></span> Buscar
                            </button>
                            <span id="loader"></span>
                        </div>
                    </div>
                </form>
                <div id="loader" style="position: absolute; text-align: center; top: 55px; width: 100%; display: none;"></div> <!-- Carga gif animado -->
                <div id="outer_div"></div> <!-- Datos ajax Final -->
            </div>
        </div>
    </div>
</div>
