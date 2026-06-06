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
                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#faqModal">FAQs</a></li>
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

<div class="modal fade" id="faqModal" tabindex="-1" aria-labelledby="faqModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="faqModalLabel">FAQs — Smart Community Problem Reporting System</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <h6 class="fw-semibold">FOR CITIZENS/COUNCILS</h6>
                </div>
                <div class="mb-3">
                    <p class="fw-bold mb-1">1. How do I submit a report?</p>
                    <p>Open the app, tap "Submit Report", select a category (e.g. "Broken streetlight", "Pothole", "Noise"), write a detailed description, take a photo, confirm the GPS location, and tap "Submit". Your report will be visible to the admin and organizations responsible for that service area.</p>
                </div>
                <div class="mb-3">
                    <p class="fw-bold mb-1">2. Why does the app need my GPS location?</p>
                    <p>GPS helps organizations locate the exact issue quickly and prioritize resolution efficiently. Your location is private — only the organization assigned to your report and admin can see the precise location. You remain safe.</p>
                </div>
                <div class="mb-3">
                    <p class="fw-bold mb-1">3. How do I track the progress of my report?</p>
                    <p>Tap the "My Reports" tab, select your report, and check its status: Pending → Assigned → In Progress → Resolved → Closed. The assigned organization will send you notifications with each update.</p>
                </div>
                <div class="mb-3">
                    <p class="fw-bold mb-1">4. Why is my report stuck on "Pending" for so long?</p>
                    <p>All reports go through a queue. Admin reviews first, then assigns to the appropriate organization based on urgency and workload. To get faster resolution, provide detailed description and a clear photo of the issue.</p>
                </div>
                <div class="mb-3">
                    <p class="fw-bold mb-1">5. Can I delete my report?</p>
                    <p>No — all reports are permanent in the system for audit trail and transparency purposes. However, you can message the assigned organization and request cancellation if the issue has been resolved elsewhere or is no longer necessary.</p>
                </div>
                <div class="mb-3">
                    <p class="fw-bold mb-1">6. Why is my password required to be strong?</p>
                    <p>For security — your resident data and report history are protected by encryption. A weak password makes your account vulnerable to hackers, putting your personal data and reports at risk.</p>
                </div>
                <div class="mb-0">
                    <p class="fw-bold mb-1">7. I forgot my password. Why didn't I receive the reset email?</p>
                    <p>Check your spam folder first. If still no email, tap "Resend reset email" or contact <a href="mailto:support@smartcommunity.local">support@smartcommunity.local</a>. Password reset links expire after 30 minutes for security.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

