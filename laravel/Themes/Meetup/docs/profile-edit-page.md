# Pagina "Modifica il profilo"

`/{lingua}/profile/edit`, solo per utenti autenticati (gli ospiti vanno al login e poi tornano qui).

| Pezzo | Dove |
|---|---|
| Contenuto CMS (titolo, testi, middleware `auth`) | `laravel/config/local/laravelpizza/database/content/pages/profile/edit.json` → slug `profile.edit` |
| Rotta | `resources/views/pages/profile/[id].blade.php`: se esiste la pagina `profile.{id}` la mostra, altrimenti `{id}` è un utente |
| Blocco | `resources/views/components/blocks/profile/edit.blade.php` |
| Form | `Modules/Meetup/app/Http/Livewire/ProfileEditForm.php` + `Modules/Meetup/resources/views/livewire/profile-edit-form.blade.php` |
| Logica | `Modules/Meetup/app/Actions/Profile/` (`ResolveOwnProfileAction`, `UpdateOwnProfileAction`, `UpdateOwnAvatarAction`, `ChangeOwnPasswordAction`), DTO `Modules/Meetup/app/Datas/OwnProfileData.php` |
| Testi | `Modules/Meetup/lang/{it,en,de,fr,es,ru}/profile_edit.php` |
| Test | `Modules/Meetup/tests/Feature/ProfileEditPageTest.php` |

Tre schede indipendenti, ognuna con il suo pulsante e la sua conferma:

1. **I tuoi dati**: nome, cognome, biografia (max 500 caratteri, pubblica), lingua preferita (quella delle email).
   L'email è in sola lettura: cambiarla richiede una nuova verifica.
2. **Foto**: JPG, PNG o WebP fino a 2 MB, una sola per volta (la vecchia viene cancellata); "Togli la foto" torna
   alle iniziali. Le foto stanno sul disco `public`: in produzione serve `php artisan storage:link`.
3. **Password**: chiede quella attuale; le altre sessioni aperte vengono chiuse.

Si arriva alla pagina dal menu utente ("Modifica il profilo"), dal menu mobile e dal pulsante sul proprio profilo
pubblico. Dopo il salvataggio il nome nel menu in alto si aggiorna senza ricaricare (evento `profile-updated`).
