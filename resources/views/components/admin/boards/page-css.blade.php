@section('page-css')
    <style>
        .supervisor-name {
            border: 1px solid #ccc;
            padding: 4px 8px;
            min-width: 250px;
            width: 250px;
            border-radius: 4px;
            background-color: #f9f9f9;
            text-align: left;
        }

        .card-header {
            background-color: #0d0172;
            border-bottom: 1px solid #060041;
            color: #fff;
            padding: 0.8rem 1rem;
        }

        .card-title {
            font-size: 1.45rem;
            font-weight: 600;
        }

        .card-body {
            background-color: #00680e;
            padding: 0.5rem;
            border-radius: 0% 0% 4px 4px;
        }

        .board-container {
            background-color: #fff;
            border-radius: 6px;
            padding: 1rem;
        }

        .board {
            border: 2px solid #00680e;
            border-radius: 6px;
            padding: 1.5rem;
            background-color: #fff;
        }

        .board-title {
            font-size: 1rem;
            font-weight: 600;
        }

        .header-logo {
            max-width: 90px;
        }

        .table>:not(caption)>*>* {
            padding: .45rem .5rem;
        }

        span.play-icon {
            background-color: #007bff;
            color: #fff;
            width: 22px;
            height: 22px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            text-align: center;
            cursor: pointer;
            margin-left: 10px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        span.play-icon.active {
            background-color: #28a745;
            transform: scale(1.1);
        }

        span.play-icon {
            display: inline-block;
            width: 20px;
            height: 20px;
        }

        i.ph {
            font-size: 16px;
        }

        @media only screen and (max-width: 768px) {
            .board-title {
                font-size: 1rem;
            }

            .card-title {
                font-size: 1.5rem;
            }

            .card-body {
                padding: 0;
            }

            .btn-sm {
                width: 100%;
                margin-top: 0.5rem;
            }

            .board-header img {
                max-width: 70px;
            }
        }

        @media only screen and (max-width: 480px) {
            .supervisor-name {
                font-size: 16px;
                padding: 6px 10px;
                min-width: 170px;
                width: 170px;
            }

            .supervisor-name-title {
                font-size: 16px;
            }

            .card-body {
                padding: 0;
            }

            .board-header img {
                max-width: 50px;
            }

            .board-title {
                font-size: 0.9rem;
            }

            .board-container {
                border-radius: 3px;
                padding: 0.5rem;
            }
        }
    </style>
@endsection
