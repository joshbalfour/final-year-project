describe('MapController', function() {
	beforeEach(module('LCP'));

	var $controller;
	var $httpBackend;

	beforeEach(inject(function(_$controller_, $injector){
		// The injector unwraps the underscores (_) from around the parameter names when matching
		$controller = _$controller_;
		$httpBackend = $injector.get('$httpBackend');

		$httpBackend.when('GET', 'app/fixtures/crossings.json')
			.respond( fixture.load('app/fixtures/crossings.json'));

		$httpBackend.when('GET', 'app/fixtures/crossings-12345.json')
			.respond( fixture.load('app/fixtures/crossings-12345.json'));

		$httpBackend.when('GET', 'app/fixtures/crossings-12345-times.json')
			.respond( fixture.load('app/fixtures/crossings-12345-times.json'));
	}));

	function createController() {
		var controller = $controller('MapController');
		controller.mapLongRange = function () {
			return 1;
		};
		return controller;
	}

	describe('initial state', function() {
		it('gateMarkers should be empty', function() {
			var controller = createController();
			expect(controller.gateMarkers.length).to.be.equal(0);
		});
	});

	describe('ctrl.init()', function() {
		it('should call loadCrossings', function() {
			var controller = createController();
			var spy = sinon.spy();

			controller.loadCrossings = spy;
			controller.init();

			assert(spy.calledOnce);
		});
	});

	describe('ctrl.loadCrossings()', function() {
		it('Should make a http request to get crossings', function() {
			$httpBackend.expectGET('app/fixtures/crossings.json');
			var controller = createController();
			controller.loadCrossings();
			$httpBackend.flush();
		});

		it('Should populate the gateMarkers array', function() {
			var controller = createController();
			controller.loadCrossings();
			$httpBackend.flush();
			expect(controller.gateMarkers.length).to.be.above(0);
		});
	});

	describe('ctrl.markerClicked()', function() {

		it('showCrossingDetails should be false before click', function() {
			var controller = createController();
			expect(controller.showCrossingDetails).to.be.equal(false);
		});

		it('showCrossingDetails should be true after click', function() {
			var controller = createController();
			controller.markerClicked(null, null, { id: 12345 });
			$httpBackend.flush();
			expect(controller.showCrossingDetails).to.be.equal(true);
		});

		it('should make a http request to get crossings/12345', function() {
			$httpBackend.expectGET('app/fixtures/crossings-12345.json');
			var controller = createController();
			controller.markerClicked(null, null, { id: 12345 });
			$httpBackend.flush();
		});

		describe('crossingDetails.meta', function () {

			it('should be undefined before running', function() {
				var controller = createController();
				expect(controller.crossingDetails.meta).to.be.equal(undefined);
			});

			it('should be not undefined after running', function() {
				var controller = createController();
				controller.markerClicked(null, null, { id: 12345 });
				$httpBackend.flush();
				expect(controller.crossingDetails.meta).to.not.be.equal(undefined);
			});
		});

	});


	describe('ctrl.closeCrossingDetals()', function() {

		it('should set showCrossingDetails to false', function () {
			var controller = createController();
			controller.showCrossingDetails = true;
			controller.closeCrossingDetals();
			expect(controller.showCrossingDetails).to.be.equal(false);
		});

		it('should set crossingDetails to an empty object', function () {
			var controller = createController();
			controller.crossingDetails = {a:123};
			controller.closeCrossingDetals();
			expect(controller.crossingDetails).to.deep.equal({});
		});

	});



	afterEach(function() {
		$httpBackend.verifyNoOutstandingExpectation();
		$httpBackend.verifyNoOutstandingRequest();
	});
});
