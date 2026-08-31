@extends($layout)

@section('title', 'Notifikasi')

@section('content')

    <div class="page-inner">

        <div class="page-header">

            <h4 class="page-title">
                Notifikasi
            </h4>

            <ul class="breadcrumbs">

                <li class="nav-home">
                    <a href="{{ route('dashboard') }}">
                        <i class="icon-home"></i>
                    </a>
                </li>

                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>

                <li class="nav-item">
                    Notifikasi
                </li>

            </ul>

        </div>


        <div class="row">

            <div class="col-md-12">

                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center">

                        <div class="card-title">
                            Daftar Notifikasi
                        </div>


                        @if (auth()->user()->unreadNotifications()->count() > 0)
                            <form action="{{ route('notifications.read-all') }}" method="POST">

                                @csrf

                                <button type="submit" class="btn btn-primary btn-sm">

                                    <i class="fa fa-check"></i>

                                    Tandai Semua Dibaca

                                </button>

                            </form>
                        @endif

                    </div>


                    <div class="card-body p-0">


                        @forelse($notifications as $notification)
                            <div
                                class="p-3 border-bottom
                            {{ is_null($notification->read_at) ? 'bg-light' : '' }}">

                                <div class="d-flex justify-content-between align-items-start">


                                    <div class="d-flex align-items-start">


                                        <div class="notif-icon notif-primary me-3">

                                            <i class="fa fa-bell"></i>

                                        </div>


                                        <div>


                                            <div class="fw-bold">

                                                {{ $notification->data['title'] ?? 'Notifikasi' }}

                                            </div>


                                            <div class="text-muted">

                                                {{ $notification->data['message'] ?? 'Anda memiliki notifikasi baru.' }}

                                            </div>


                                            <small class="text-muted">

                                                <i class="fa fa-clock"></i>

                                                {{ $notification->created_at->diffForHumans() }}

                                            </small>


                                        </div>

                                    </div>


                                    <div>

                                        @if (is_null($notification->read_at))
                                            <span class="badge badge-primary">
                                                Baru
                                            </span>
                                        @else
                                            <span class="badge badge-success">
                                                Dibaca
                                            </span>
                                        @endif

                                    </div>


                                </div>


                                @if (is_null($notification->read_at))
                                    <div class="mt-3">

                                        <form
                                            action="{{ route('notifications.read', $notification->id) }}"
                                            method="POST">

                                            @csrf

                                            <button type="submit" class="btn btn-sm btn-outline-primary">

                                                <i class="fa fa-check"></i>

                                                Tandai Sudah Dibaca

                                            </button>

                                        </form>

                                    </div>
                                @endif


                            </div>


                        @empty


                            <div class="text-center text-muted py-5">

                                <i class="fa fa-bell-slash fa-3x mb-3"></i>


                                <h5>
                                    Belum Ada Notifikasi
                                </h5>


                                <p>
                                    Notifikasi Anda akan muncul di sini.
                                </p>


                            </div>
                        @endforelse


                    </div>


                    @if ($notifications->hasPages())
                        <div class="card-footer">

                            {{ $notifications->links() }}

                        </div>
                    @endif


                </div>

            </div>

        </div>

    </div>

@endsection
