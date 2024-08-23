<?php
/**
 * Call to log in a user based on an external identity provider $source with external $identifier
 * A new user is created based on $fields if it's a new combination of $source and $identifier
 *
 * @param $source
 * @param $identifier
 * @param $fields
 *
 * @return mixed
 */
function qa_log_in_external_user($source, $identifier, $fields)
{
    require_once QA_INCLUDE_DIR . 'db/users.php';

    $users = qa_db_user_login_find($source, $identifier);
    $countusers = count($users);

    if ($countusers > 1) {
        qa_fatal_error('External login mapped to more than one user');
    } // should never happen

    if ($countusers) // user exists so log them in
    {
        qa_set_logged_in_user($users[0]['userid'], $users[0]['handle'], false, $source);
    } else { // create and log in user
        require_once QA_INCLUDE_DIR . 'app/users-edit.php';

        qa_db_user_login_sync(true);

        $users = qa_db_user_login_find($source, $identifier); // check again after table is locked

        if (count($users) == 1) {
            qa_db_user_login_sync(false);
            qa_set_logged_in_user($users[0]['userid'], $users[0]['handle'], false, $source);

        } else {
            $handle = qa_handle_make_valid(@$fields['handle']);

            $shouldCreateNewUser = true;

            if (strlen($fields['email'] ?? '')) {
                $emailusers = qa_db_user_find_by_email($fields['email']);
                if (!empty($emailusers)) {
                    $shouldCreateNewUser = false;
                    $userid = $emailusers[0];
                    $handle = qa_userid_to_handle($userid);

                    qa_db_user_set_flag($userid, QA_USER_FLAGS_EMAIL_CONFIRMED, true);

                    qa_db_user_login_add($userid, $source, $identifier);
                    qa_db_user_login_sync(false);
                }
            }

            if ($shouldCreateNewUser) {
                $userid = qa_create_new_user((string)@$fields['email'], null /* no password */, $handle,
                    isset($fields['level']) ? $fields['level'] : QA_USER_LEVEL_BASIC, @$fields['confirmed']);

                qa_db_user_login_add($userid, $source, $identifier);
                qa_db_user_login_sync(false);

                $profilefields = ['name', 'location', 'website', 'about'];

                foreach ($profilefields as $fieldname) {
                    if (strlen($fields[$fieldname] ?? '')) {
                        qa_db_user_profile_set($userid, $fieldname, $fields[$fieldname]);
                    }
                }

                if (strlen($fields['avatar'] ?? '')) {
                    qa_set_user_avatar($userid, $fields['avatar']);
                }
            }

            qa_set_logged_in_user($userid, $handle, false, $source);
        }
    }
}
