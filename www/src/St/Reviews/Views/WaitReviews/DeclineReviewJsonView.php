<?php

namespace St\Reviews\Views\WaitReviews;

use St\Views\IView;

class DeclineReviewJsonView extends ApproveReviewJsonView implements IChangeWaitReviewStatusView, \JsonSerializable, IView
{
}