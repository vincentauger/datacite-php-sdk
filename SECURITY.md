# Security

## Reporting Issues

If you find a security issue in this SDK, please open a GitHub issue. Since this is a client SDK for the public DataCite API, most security concerns will be addressed promptly through normal bug fixes.

## Credential Safety

This SDK requires DataCite member credentials for write operations:

- **Never commit credentials to version control**
- Store credentials in `.env` files (already gitignored)
- Use environment variables for production deployments
- Rotate credentials if accidentally exposed

## Notes

- This SDK only communicates with DataCite's official API endpoints over HTTPS
- All input validation follows DataCite's API requirements
- Security updates are released as needed and documented in [CHANGELOG.md](CHANGELOG.md)
