# Security Policy

## Supported Versions

We release patches for security vulnerabilities for the following versions:

| Version | Supported          |
| ------- | ------------------ |
| 1.x     | :white_check_mark: |

## Reporting a Vulnerability

If you discover a security vulnerability within this package, please send an email to Vincent Auger at vincent.auger@gmail.com. All security vulnerabilities will be promptly addressed.

**Please do not create public GitHub issues for security vulnerabilities.**

When reporting a vulnerability, please include:

- A description of the vulnerability
- Steps to reproduce the issue
- Possible impact of the vulnerability
- Any suggested fixes (if available)

We will acknowledge receipt of your vulnerability report within 48 hours and will send you regular updates about our progress. If you have not received a reply to your submission within 48 hours, please follow up via email to ensure we received your original message.

## Security Updates

Security updates will be released as patch versions (e.g., 1.0.1) and will be documented in the [CHANGELOG.md](CHANGELOG.md).

## Best Practices

When using this SDK:

1. **Keep credentials secure** - Never commit DataCite API credentials to version control
2. **Use environment variables** - Store sensitive credentials in `.env` files (excluded from git)
3. **Keep the SDK updated** - Regularly update to the latest version to receive security patches
4. **Validate input** - Always validate and sanitize user input before using it with the SDK
5. **Use HTTPS** - The SDK defaults to HTTPS for all API calls (do not override this)

## Responsible Disclosure

We follow the principle of responsible disclosure. We ask that you:

- Allow us reasonable time to address the vulnerability before public disclosure
- Make a good faith effort to avoid privacy violations and data destruction
- Do not exploit the vulnerability beyond what is necessary to demonstrate it
