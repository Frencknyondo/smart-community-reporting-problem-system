<footer class="footer-dark py-5">
    <style>
        .footer-dark {
            background: #111827;
            color: #e5e7eb;
        }
        .footer-dark a {
            color: #f8fafc;
            text-decoration: none;
        }
        .footer-dark a:hover {
            text-decoration: underline;
        }
        .footer-dark .footer-link-title {
            font-weight: 700;
            margin-bottom: 16px;
        }
        .footer-dark .footer-note {
            color: #94a3b8;
            font-size: 0.92rem;
        }
        .footer-brand-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }
        .footer-brand-main {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            min-width: 0;
        }
        .footer-brand-main h5 {
            line-height: 1.25;
        }
        @media (max-width: 576px) {
            .footer-brand-row {
                align-items: flex-start;
            }
            .footer-brand-main h5 {
                font-size: 0.98rem;
            }
        }
    </style>
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-4">
                <div class="footer-brand-row mb-3">
                    <div class="footer-brand-main">
                        <img src="{{ asset('img/favicon.png') }}" alt="Logo" style="width:48px; height:48px; object-fit: contain;">
                        <h5 class="text-white mb-0">Smart Community Problem Reporting System</h5>
                    </div>
                </div>
                <p class="footer-note">A civic reporting platform that helps residents submit local issues and keep communities safer through faster council response.</p>
            </div>
            <div class="col-md-2">
                <div class="footer-link-title">Report</div>
                <ul class="list-unstyled mb-0">
                    <li><a href="/report">Report a problem</a></li>
                    <li><a href="/about">How it works</a></li>
                    <li><a href="/login">Sign in</a></li>
                </ul>
            </div>
            <div class="col-md-2">
                <div class="footer-link-title">Resources</div>
                <ul class="list-unstyled mb-0">
                    <li><a href="/about">FAQs</a></li>
                    <li><a href="/contact">Contact us</a></li>
                    <li><a href="#">Privacy</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <div class="bg-white rounded-4 p-4" style="color:#111827;">
                    <h6 class="fw-bold mb-2">Help improve your community</h6>
                    <p class="mb-3">Submit local issues, get updates, and work with authorities to resolve public problems faster.</p>
                    <a href="/report" class="btn btn-primary">Report now</a>
                </div>
            </div>
        </div>
        <hr class="border-secondary my-4">
        <div class="text-center footer-note">
            &copy; {{ date('Y') }} Smart Community Problem Reporting System (Community reporting for local issues)
        </div>
    </div>
</footer>

