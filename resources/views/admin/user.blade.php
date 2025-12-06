@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endsection

@section('content')
<div class="dashboard-container">
    @include('admin.sections.sidebar')
    <main class="main-content">
            <header class="main-header">
                <h2 class="page-title">Users</h2>
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search for...">
                </div>
            </header>

            <section class="data-table-section">
                <div class="table-info">
                    <span class="status">All Users</span>
                    <span class="pagination-summary">1-10 of 256</span>
                </div>
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th><input type="checkbox"></th>
                                <th>Name <i class="fas fa-chevron-down"></i></th>
                                <th>Phone <i class="fas fa-chevron-down"></i></th>
                                <th>Location <i class="fas fa-chevron-down"></i></th>
                                <th>Company <i class="fas fa-chevron-down"></i></th>
                                <th>Status <i class="fas fa-chevron-down"></i></th>
                                <th></th> </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>
                                    <div class="user-cell">
                                        <i class="fas fa-user-circle avatar"></i>
                                        <div>
                                            <span class="user-name">John Doe</span>
                                            <span class="user-email">john@google.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td>(414) 807 - 1234</td>
                                <td>United States</td>
                                <td class="company-cell">
                                    <i class="fab fa-google company-icon google"></i>
                                    Google
                                </td>
                                <td><span class="status-badge online">Online</span></td>
                                <td>
                                    <i class="fas fa-pen edit-icon"></i>
                                    <i class="fas fa-trash-alt delete-icon"></i>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>
                                    <div class="user-cell">
                                        <i class="fas fa-user-circle avatar"></i>
                                        <div>
                                            <span class="user-name">Sophie Moore</span>
                                            <span class="user-email">sophie@webflow.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td>(240) 480 - 4277</td>
                                <td>United Kingdom</td>
                                <td class="company-cell">
                                    <i class="fab fa-dribbble company-icon webflow"></i>
                                    Webflow
                                </td>
                                <td><span class="status-badge offline">Offline</span></td>
                                <td>
                                    <i class="fas fa-pen edit-icon"></i>
                                    <i class="fas fa-trash-alt delete-icon"></i>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>
                                    <div class="user-cell">
                                        <i class="fas fa-user-circle avatar"></i>
                                        <div>
                                            <span class="user-name">Matt Cannon</span>
                                            <span class="user-email">matt@facebook.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td>(310) 698 - 9889</td>
                                <td>Australia</td>
                                <td class="company-cell">
                                    <i class="fab fa-facebook company-icon facebook"></i>
                                    Facebook
                                </td>
                                <td><span class="status-badge offline">Offline</span></td>
                                <td>
                                    <i class="fas fa-pen edit-icon"></i>
                                    <i class="fas fa-trash-alt delete-icon"></i>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>
                                    <div class="user-cell">
                                        <i class="fas fa-user-circle avatar"></i>
                                        <div>
                                            <span class="user-name">Graham Hills</span>
                                            <span class="user-email">graham@twitter.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td>(540) 827 - 3890</td>
                                <td>India</td>
                                <td class="company-cell">
                                    <i class="fab fa-twitter company-icon twitter"></i>
                                    Twitter
                                </td>
                                <td><span class="status-badge online">Online</span></td>
                                <td>
                                    <i class="fas fa-pen edit-icon"></i>
                                    <i class="fas fa-trash-alt delete-icon"></i>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>
                                    <div class="user-cell">
                                        <i class="fas fa-user-circle avatar"></i>
                                        <div>
                                            <span class="user-name">Sandy Houston</span>
                                            <span class="user-email">sandy@youtube.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td>(440) 410 - 3848</td>
                                <td>Canada</td>
                                <td class="company-cell">
                                    <i class="fab fa-youtube company-icon youtube"></i>
                                    YouTube
                                </td>
                                <td><span class="status-badge offline">Offline</span></td>
                                <td>
                                    <i class="fas fa-pen edit-icon"></i>
                                    <i class="fas fa-trash-alt delete-icon"></i>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>
                                    <div class="user-cell">
                                        <i class="fas fa-user-circle avatar"></i>
                                        <div>
                                            <span class="user-name">Andy Smith</span>
                                            <span class="user-email">andy@reddit.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td>(504) 450 - 3268</td>
                                <td>United States</td>
                                <td class="company-cell">
                                    <i class="fab fa-reddit company-icon reddit"></i>
                                    Reddit
                                </td>
                                <td><span class="status-badge online">Online</span></td>
                                <td>
                                    <i class="fas fa-pen edit-icon"></i>
                                    <i class="fas fa-trash-alt delete-icon"></i>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>
                                    <div class="user-cell">
                                        <i class="fas fa-user-circle avatar"></i>
                                        <div>
                                            <span class="user-name">Lily Woods</span>
                                            <span class="user-email">lily@spotify.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td>(360) 692 - 1919</td>
                                <td>Australia</td>
                                <td class="company-cell">
                                    <i class="fab fa-spotify company-icon spotify"></i>
                                    Spotify
                                </td>
                                <td><span class="status-badge offline">Offline</span></td>
                                <td>
                                    <i class="fas fa-pen edit-icon"></i>
                                    <i class="fas fa-trash-alt delete-icon"></i>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>
                                    <div class="user-cell">
                                        <i class="fas fa-user-circle avatar"></i>
                                        <div>
                                            <span class="user-name">Patrick Meyer</span>
                                            <span class="user-email">patrick@pinterest.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td>(760) 562 - 9870</td>
                                <td>United Kingdom</td>
                                <td class="company-cell">
                                    <i class="fab fa-pinterest-p company-icon pinterest"></i>
                                    Pinterest
                                </td>
                                <td><span class="status-badge online">Online</span></td>
                                <td>
                                    <i class="fas fa-pen edit-icon"></i>
                                    <i class="fas fa-trash-alt delete-icon"></i>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>
                                    <div class="user-cell">
                                        <i class="fas fa-user-circle avatar"></i>
                                        <div>
                                            <span class="user-name">Frances Willen</span>
                                            <span class="user-email">frances@twitch.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td>(210) 496 - 3864</td>
                                <td>Canada</td>
                                <td class="company-cell">
                                    <i class="fab fa-twitch company-icon twitch"></i>
                                    Twitch
                                </td>
                                <td><span class="status-badge offline">Offline</span></td>
                                <td>
                                    <i class="fas fa-pen edit-icon"></i>
                                    <i class="fas fa-trash-alt delete-icon"></i>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox"></td>
                                <td>
                                    <div class="user-cell">
                                        <i class="fas fa-user-circle avatar"></i>
                                        <div>
                                            <span class="user-name">Ernest Houston</span>
                                            <span class="user-email">ernest@linkedin.com</span>
                                        </div>
                                    </div>
                                </td>
                                <td>(704) 339 - 1813</td>
                                <td>India</td>
                                <td class="company-cell">
                                    <i class="fab fa-linkedin-in company-icon linkedin"></i>
                                    LinkedIn
                                </td>
                                <td><span class="status-badge offline">Offline</span></td>
                                <td>
                                    <i class="fas fa-pen edit-icon"></i>
                                    <i class="fas fa-trash-alt delete-icon"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <footer class="main-footer">
                <span class="table-count">1-10 of 460</span>
                <div class="pagination-controls">
                    <span>Rows per page:</span>
                    <span class="row-count">10</span>
                    <button class="nav-button"><i class="fas fa-angle-left"></i></button>
                    <button class="nav-button"><i class="fas fa-angle-right"></i></button>
                </div>
            </footer>
    </main>
</div>
@endsection
