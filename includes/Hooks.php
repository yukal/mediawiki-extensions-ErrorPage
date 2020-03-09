<?php
/**
 * ErrorPage Hooks
 *
 * @file
 * @ingroup Extensions
 * @version 1.0
 * @author Alexander Yukal <yukal@email.ua>
 * @license https://opensource.org/licenses/MIT MIT License
 * @link https://www.mediawiki.org/wiki/Extension:ErrorPage Documentation
 */

namespace MediaWiki\Extension\ErrorPage;

use MediaWiki\MediaWikiServices;
use Article;
use SkinTemplate;

class Hooks {

	public static function onSkinTemplateNavigation( SkinTemplate $skinTemplate, Array &$links ) {
		if (!$skinTemplate->getContext()->getUser()->isLoggedIn() && 
			!$skinTemplate->getTitle()->getArticleID()) {
			$links = [];
		}
	}

	public static function onBeforeDisplayNoArticleText(Article $article) {
		$mwsInstance = MediaWikiServices::getInstance();
		$wgSend404Code = $mwsInstance->getMainConfig()->get('Send404Code');

		$title = $article->getTitle();
		$validUserPage = $title->isSubpage();
		$loggedIn = $article->getContext()->getUser()->isLoggedIn();
		$sessionExists = $article->getContext()->getRequest()->getSession()->isPersistent();

		if ( !$article->getPage()->hasViewableContent() && $wgSend404Code && !$validUserPage ) {
			$out = $article->getContext()->getOutput();

			$defaultStatusCode = 404;
			$statusCode = $title->isDeleted() ?410 :404;
			$out->setStatusCode( $defaultStatusCode );

			if (!$loggedIn) {
				$msgNotFound = wfMessage( 'errorpage-title', $defaultStatusCode );
				$msgSubtitle = wfMessage( 'errorpage-status-'.$statusCode );
	
				$out->clearHTML();
				$out->setPageTitle( $msgNotFound );
				//$out->setHTMLTitle( $msgNotFound );
				$out->addWikiMsg( 'errorpage-body', $msgSubtitle, $title->getBaseText());
				// $out->addWikiMsg( 'noarticletext-nopermission' );

				return false;
			}
		}

		return true;
	}

}
