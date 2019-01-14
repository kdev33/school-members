const BASEURL = 'http://localhost/members-school/';

/**
 *
 * @param {string} pTitle
 * @param {string} pText Text content of notification
 * @param {string} pType type of notification
 * @param {int} pDelay time of notification in miliseconds
 * @param {string} pAlign horizontal alignment of notification in view
 * @param {string} pVerticalAlign vertical alignment alignment of notification in view
 */
const notify = ( pTitle, pText, pType, pDelay = 3000, pAlign = 'right', pVerticalAlign = 'top', ) => {
    console.log( "*------ notify!! ------*" );
    $.notify( {
        title: '<strong>' + pTitle + '</strong>',
        message: pText
    }, {
        type: pType,
        delay: pDelay,
        allow_dismiss: true,
        placement: {
            from: pVerticalAlign,
            align: pAlign
        }
    } );
}; //notify

/**
 * Send new member to server to be inserted into the database
 */
const addMember = () => {
    console.log( "*------ addMember!! ------*" );
    const
        NAME = document.querySelector( '.add .name' ).value,
        EMAIL = document.querySelector( '.add .email' ).value,
        SCHOOL = $( '.add .school select' ).val(),
        DATA = {
            name: NAME,
            email: EMAIL,
            school: SCHOOL
        };

    //make request
    $.ajax( {
        type: 'POST',
        url: BASEURL + 'backend/add.php',
        data: DATA,
        dataType: 'JSON',
        encode: true,
        success: ( resp ) => {
            console.log( "%c Request done successfully. ", "color: green" );
            notify( 'Success', 'Member added!', 'success' );
        },
        error: ( e ) => {
            console.log( "%c Request done unsuccessfully. ", "color: red" );
            notify( 'Error', 'Error!', 'danger' );
        }
    } );
}; //addMember

/**
 * Get members that match given school id
 */
const getMembers = () => {
    console.log( "*------ getMembers!! ------*" );
    const SCHOOL = $( '.get select' ).val();

    //make request
    $.ajax( {
        type: 'GET',
        url: BASEURL + 'backend/get.php?school=' + SCHOOL,
        success: ( resp ) => {
            console.log( "%c Request done successfully. ", "color: green" );
            const TABLEBODY = document.querySelector( 'table tbody' );

            //remove childs from table body
            if ( TABLEBODY.hasChildNodes() ) {
                while ( TABLEBODY.firstChild ) {
                    TABLEBODY.removeChild( TABLEBODY.firstChild );
                }
            }

            //check if some error happened or no data found
            if ( resp.message ) {
                notify( 'Ups!', resp.message, 'warning' );
                return;
            }

            notify( 'Success', 'Members received!', 'success' );

            //populate table with retrieved data
            resp.forEach( function( val, key ) {
                console.log( "val: " + val + " key: " + key );
                let name = val.name,
                    email = val.email,
                    tr = document.createElement( 'tr' ),
                    tdname = document.createElement( 'td' ),
                    tdemail = document.createElement( 'td' );

                tdname.textContent = name;
                tdemail.textContent = email;

                tr.appendChild( tdname );
                tr.appendChild( tdemail );
                TABLEBODY.appendChild( tr );

            } ); //end forEach

        },
        error: ( e ) => {
            console.log( "%c Request done unsuccessfully. ", "color: red" );
            notify( 'Error', 'Error!', 'danger' );
        }
    } );

}; //getMembers

/**
 * Initialize application
 */
const init = () => {
    console.log( "%c *------ init!! ------*", "color: blue" );

    document.querySelector( '.add button' ).addEventListener( "click", addMember );
    document.querySelector( '.get button' ).addEventListener( "click", getMembers );

}; //init

init();
