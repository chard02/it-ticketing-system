@if ($tiket->statusTiket && in_array($tiket->statusTiket->nama_status, ['BARU', 'DIBUKA KEMBALI']))

    <div class="card card-round">

        <div class="card-header">

            <div class="card-title">

                <i class="fas fa-user-cog me-2"></i>

                Assign Tiket

            </div>

        </div>


        <form action="{{ route('admin.tiket.assign', $tiket->id) }}" method="POST">

            @csrf

            @method('PUT')


            <div class="card-body">


                {{-- TEKNISI --}}
                <div class="mb-3">

                    <label class="form-label">

                        Teknisi
                        <span class="text-danger">*</span>

                    </label>


                    <select name="teknisi_id" class="form-select @error('teknisi_id') is-invalid @enderror">

                        <option value="">

                            -- Pilih Teknisi --

                        </option>


                        @foreach ($teknisi as $item)
                            <option value="{{ $item->id }}" @selected(old('teknisi_id', $tiket->teknisi_id) == $item->id)>

                                {{ $item->nama }}

                                @if ($item->nip)
                                    - {{ $item->nip }}
                                @endif

                            </option>
                        @endforeach

                    </select>


                    @error('teknisi_id')
                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>
                    @enderror

                </div>


                {{-- PRIORITAS --}}
                <div class="mb-3">

                    <label class="form-label">

                        Prioritas
                        <span class="text-danger">*</span>

                    </label>


                    <select name="prioritas_tiket_id"
                        class="form-select @error('prioritas_tiket_id') is-invalid @enderror">

                        <option value="">

                            -- Pilih Prioritas --

                        </option>


                        @foreach ($prioritas as $item)
                            <option value="{{ $item->id }}" @selected(old('prioritas_tiket_id', $tiket->prioritas_tiket_id) == $item->id)>

                                {{ $item->nama_prioritas }}

                            </option>
                        @endforeach

                    </select>


                    @error('prioritas_tiket_id')
                        <div class="invalid-feedback">

                            {{ $message }}

                        </div>
                    @enderror

                </div>


                {{-- INFORMASI --}}
                <div class="alert alert-info">

                    <div class="d-flex">

                        <div class="me-2">

                            <i class="fas fa-info-circle"></i>

                        </div>

                        <div>

                            Setelah tiket ditugaskan:

                            <ul class="mb-0 mt-2">

                                <li>
                                    Teknisi akan menerima tiket.
                                </li>

                                <li>
                                    Prioritas tiket akan ditentukan.
                                </li>

                                <li>
                                    Status tiket berubah menjadi
                                    <strong>DITUGASKAN</strong>.
                                </li>

                            </ul>

                        </div>

                    </div>

                </div>


            </div>


            <div class="card-footer">

                <button type="submit" class="btn btn-primary w-100">

                    <i class="fas fa-user-check me-2"></i>

                    Assign Teknisi

                </button>

            </div>

        </form>

    </div>

@endif
