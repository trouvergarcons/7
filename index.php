<?php
// index.php - Company Home Page
$pageTitle = 'Home - Enterprise Intelligence & Personnel Portal';
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/header.php';
?>

<!-- Hero Section -->
<section class="hero">
    <div class="container hero-grid">
        <div class="hero-left">
            <div class="hero-tag">
                <span>⚡ Next-Gen Enterprise Architecture</span>
            </div>
            <h1 class="hero-title">
                ApexCorp <span class="text-gradient">Innovations</span>
            </h1>
            <p class="hero-desc">
                Pioneering corporate solutions, secure digital transformation, and seamless collaboration between corporate leadership and operational teams worldwide.
            </p>
            <div class="hero-actions">
                <?php if ($currentUser): ?>
                    <a href="dashboard.php" class="btn btn-primary btn-lg">
                        <span>Go to My Directory (<?php echo ucfirst($currentUser['role']); ?>)</span> &rarr;
                    </a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-primary btn-lg">Portal Sign In</a>
                    <a href="register.php" class="btn btn-secondary btn-lg">Register Account</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="hero-right">
            <div class="hero-card-preview">
                <div class="preview-badge-row">
                    <span class="badge badge-admin"><i class="fa-solid fa-building-shield"></i> Corporate Portal</span>
                    <span style="color: #34d399; font-size: 0.88rem; font-weight: 700; display: inline-flex; align-items: center; gap: 8px;">
                        <span class="live-pulse-dot"></span> Live Demo Ready
                    </span>
                </div>
                <h3 style="font-size: 1.35rem; margin-bottom: 12px; color: #ffffff;">Role-Based Directory Exchange</h3>
                <p style="color: #94a3b8; font-size: 0.95rem; margin-bottom: 20px;">
                    Test the live authentication condition in one click:
                </p>
                <ul class="portal-features-list">
                    <li>
                        <span class="check-icon"><i class="fa-solid fa-check"></i></span>
                        <span><strong>Employee Login:</strong> Authenticates & reveals <strong>all Admin details</strong> (Leadership, emails, phones, floors).</span>
                    </li>
                    <li>
                        <span class="check-icon"><i class="fa-solid fa-check"></i></span>
                        <span><strong>Admin Login:</strong> Authenticates & reveals <strong>all Employee details</strong> (Full staff directory, departments, tech roles).</span>
                    </li>
                    <li>
                        <span class="check-icon"><i class="fa-solid fa-check"></i></span>
                        <span>Integrated with live <strong>MySQL / phpMyAdmin</strong> database on port <?php echo htmlspecialchars($active_port); ?>.</span>
                    </li>
                </ul>

                <div style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); padding: 18px; border-radius: var(--radius-md); margin-top: 20px;">
                    <div style="color: #cbd5e1; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;">
                        ⚡ Instant 1-Click Role Login:
                    </div>
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <form action="login.php" method="POST" style="flex: 1; min-width: 140px;">
                            <input type="hidden" name="email" value="john.dev@apexcorp.com">
                            <input type="hidden" name="password" value="Emp@123">
                            <button type="submit" class="btn btn-block" style="background: linear-gradient(135deg, #0284c7, #0ea5e9); color: white; padding: 10px; font-size: 0.88rem; box-shadow: 0 4px 12px rgba(14, 165, 233, 0.35);">
                                <i class="fa-solid fa-user"></i> Login Employee
                            </button>
                        </form>
                        <form action="login.php" method="POST" style="flex: 1; min-width: 140px;">
                            <input type="hidden" name="email" value="admin@apexcorp.com">
                            <input type="hidden" name="password" value="Admin@123">
                            <button type="submit" class="btn btn-block" style="background: linear-gradient(135deg, #7c3aed, #8b5cf6); color: white; padding: 10px; font-size: 0.88rem; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.35);">
                                <i class="fa-solid fa-crown"></i> Login Admin
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Ribbon -->
<div class="container stats-section">
    <div class="stats-grid">
        <div class="stat-item">
            <div class="stat-number">500+</div>
            <div class="stat-label">Enterprise Clients Worldwide</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">99.99%</div>
            <div class="stat-label">System High Availability</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">4</div>
            <div class="stat-label">Global Tech Centers</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">150+</div>
            <div class="stat-label">Certified Personnel</div>
        </div>
    </div>
</div>

<!-- Services Section -->
<section class="section-py" id="services">
    <div class="container">
        <div class="section-header">
            <span class="section-sub">Enterprise Capabilities</span>
            <h2 class="section-title">Built for Scalable Corporate Operations</h2>
            <p class="section-desc">
                From cloud infrastructure to automated people operations, ApexCorp powers the modern enterprise workflow.
            </p>
        </div>

        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">☁️</div>
                <h3 class="service-title">Cloud Infrastructure</h3>
                <p class="service-text">
                    Multi-region distributed cloud architectures designed for high fault-tolerance, zero-latency microservices, and elastic enterprise scaling.
                </p>
            </div>
            <div class="service-card">
                <div class="service-icon">🛡️</div>
                <h3 class="service-title">Zero-Trust Cybersecurity</h3>
                <p class="service-text">
                    End-to-end cryptographic safeguards, role-based access matrix controls, and automated compliance auditing according to ISO 27001 standards.
                </p>
            </div>
            <div class="service-card">
                <div class="service-icon">📊</div>
                <h3 class="service-title">Enterprise Analytics</h3>
                <p class="service-text">
                    Actionable intelligence across departments with automated reporting pipelines and predictive analytics for operational forecasting.
                </p>
            </div>
            <div class="service-card">
                <div class="service-icon">👥</div>
                <h3 class="service-title">Human Capital Portal</h3>
                <p class="service-text">
                    Transparent directory allowing employees direct access to executive leadership contact points while equipping admins with staff management tools.
                </p>
            </div>
            <div class="service-card">
                <div class="service-icon">🚀</div>
                <h3 class="service-title">Continuous Integration</h3>
                <p class="service-text">
                    Automated deployment pipelines and devops workflows enabling weekly zero-downtime releases with automated regression checking.
                </p>
            </div>
            <div class="service-card">
                <div class="service-icon">🌐</div>
                <h3 class="service-title">Global Coordination</h3>
                <p class="service-text">
                    Real-time directory synchronization across satellite offices in New York, San Francisco, Chicago, and remote worldwide hubs.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Role Matrix Showcase Section -->
<section class="section-py matrix-section" id="portal-matrix">
    <div class="container">
        <div class="section-header">
            <span class="section-sub">Access Control Architecture</span>
            <h2 class="section-title">Dual-Role Authentication Workflow</h2>
            <p class="section-desc">
                Complies with enterprise protocol: Employees authenticate to view company Administrators, while Administrators authenticate to inspect all registered Employees.
            </p>
        </div>

        <div class="matrix-grid">
            <!-- Employee Card -->
            <div class="matrix-card employee-card">
                <div class="matrix-role-header">
                    <div class="matrix-avatar emp">💼</div>
                    <div>
                        <span class="badge badge-employee">Employee Account</span>
                        <h3 style="margin-top: 4px; font-size: 1.25rem;">Staff Member Experience</h3>
                    </div>
                </div>
                <div class="matrix-rule">
                    <strong>Rule:</strong> When an <em>Employee</em> logs in, the portal authenticates the session and presents the <strong>Complete Admin Directory</strong>.
                </div>
                <ul style="list-style: none; margin-bottom: 24px;">
                    <li style="margin-bottom: 8px; font-size: 0.92rem; color: #475569;">✓ View Executive Leadership & Dept Heads</li>
                    <li style="margin-bottom: 8px; font-size: 0.92rem; color: #475569;">✓ Access Admin corporate email & direct phone lines</li>
                    <li style="margin-bottom: 8px; font-size: 0.92rem; color: #475569;">✓ Filter Admins by Executive, HR, Tech, or Operations</li>
                </ul>
                <a href="login.php" class="btn btn-outline btn-block">Sign In as Employee</a>
            </div>

            <!-- Admin Card -->
            <div class="matrix-card admin-card">
                <div class="matrix-role-header">
                    <div class="matrix-avatar adm">👑</div>
                    <div>
                        <span class="badge badge-admin">Admin Account</span>
                        <h3 style="margin-top: 4px; font-size: 1.25rem;">Executive / Admin Experience</h3>
                    </div>
                </div>
                <div class="matrix-rule">
                    <strong>Rule:</strong> When an <em>Admin</em> logs in, the portal authenticates the session and presents the <strong>Complete Employee Directory</strong>.
                </div>
                <ul style="list-style: none; margin-bottom: 24px;">
                    <li style="margin-bottom: 8px; font-size: 0.92rem; color: #475569;">✓ Inspect full corporate personnel roster</li>
                    <li style="margin-bottom: 8px; font-size: 0.92rem; color: #475569;">✓ Monitor employee designations, emails & office locations</li>
                    <li style="margin-bottom: 8px; font-size: 0.92rem; color: #475569;">✓ Live instant search & department-level filtering</li>
                </ul>
                <a href="login.php" class="btn btn-primary btn-block">Sign In as Admin</a>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Banner -->
<section style="background: linear-gradient(135deg, var(--secondary), #1e293b); color: white; padding: 70px 0; text-align: center;">
    <div class="container" style="max-width: 720px;">
        <h2 style="font-size: 2.2rem; margin-bottom: 16px;">Ready to Join or Manage the Team?</h2>
        <p style="color: #94a3b8; font-size: 1.05rem; margin-bottom: 30px;">
            Create your staff profile in under 60 seconds or sign in with your corporate credentials to view your assigned personnel directory.
        </p>
        <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
            <a href="register.php" class="btn btn-primary btn-lg">Register New Account</a>
            <a href="login.php" class="btn btn-secondary btn-lg">Access Portal</a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
