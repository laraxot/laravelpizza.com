---
name: socialite-configuration-guide
description: **Guide**: Configure social authentication credentials via Filament BackOffice
**Applies to**: laravel/Modules/User
**Enforced by**: Security best practices and modular architecture

**Step-by-Step Tutorial**:

1. **Access BackOffice**
   ```bash
   php artisan filament:admin
   ```
   Navigate to User module settings

2. **Social Providers Management**
   - Go to Settings > Social Authentication
   - Click "Add Provider"
   - Select provider type (Google, Facebook, etc.)

3. **Google OAuth Configuration**
   ```json
   {
     "provider": "google",
     "client_id": "YOUR_GOOGLE_CLIENT_ID",
     "client_secret": "YOUR_GOOGLE_CLIENT_SECRET",
     "redirect_uri": "/auth/google/callback"
   }
   ```

4. **Security Considerations**
   - Store credentials in encrypted configuration
   - Use environment variables in production
   - Enable API access in Google Cloud Console
   - Configure allowed redirect URIs

5. **Testing Configuration**
   ```bash
   php artisan tinker
   > Socialite::driver('google')->redirect();
   ```
   Should redirect to Google OAuth screen

**Files Modified**:
- `laravel/Modules/User/config/socialite.php` - Provider configuration
- `laravel/Modules/User/app/Models/SocialProvider.php` - Provider model
- `laravel/Modules/User/app/Models/SocialiteUser.php` - User mapping

**Troubleshooting**:
- Check Google Cloud Console OAuth credentials
- Verify redirect URI matches exactly
- Ensure proper scope permissions
  