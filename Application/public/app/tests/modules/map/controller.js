describe('MapController', function() {
	beforeEach(module('LCP'));

	var $controller;
	var $httpBackend;
	var controller;

	beforeEach(inject(function(_$controller_, $injector){
		// The injector unwraps the underscores (_) from around the parameter names when matching
		$controller = _$controller_;
		$httpBackend = $injector.get('$httpBackend');

		$httpBackend.when('GET', 'crossings')
			.respond( fixture.load('app/fixtures/crossings.json'));

		$httpBackend.when('GET', 'crossings/12345')
			.respond( fixture.load('app/fixtures/crossings-12345.json'));

		$httpBackend.when('GET', 'crossings/12345/times')
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
			controller = createController();
			expect(controller.gateMarkers.length).to.be.equal(0);
		});
	});

	describe('ctrl.init()', function() {
		it('should call loadCrossings', function() {
			controller = createController();
			var spy = sinon.spy();

			controller.loadCrossings = spy;
			controller.init();

			assert(spy.calledOnce);
		});
	});

	describe('ctrl.loadCrossings()', function() {
		it('Should make a http request to get crossings', function() {
			$httpBackend.expectGET('crossings');
			controller = createController();
			controller.loadCrossings();
			$httpBackend.flush();
		});

		it('Should populate the gateMarkers array', function() {
			controller = createController();
			controller.loadCrossings();
			$httpBackend.flush();
			expect(controller.gateMarkers.length).to.be.above(0);
		});
	});

	describe('ctrl.markerClicked()', function() {

		it('showCrossingDetails should be false before click', function() {
			controller = createController();
			expect(controller.showCrossingDetails).to.be.equal(false);
		});

		it('showCrossingDetails should be true after click', function() {
			controller = createController();
			controller.markerClicked(null, null, { id: 12345 });
			$httpBackend.flush();
			expect(controller.showCrossingDetails).to.be.equal(true);
		});

		it('should make a http request to get crossings/12345', function() {
			$httpBackend.expectGET('crossings/12345');
			controller = createController();
			controller.markerClicked(null, null, { id: 12345 });
			$httpBackend.flush();
		});

		describe('crossingDetails.meta', function () {

			it('should be undefined before running', function() {
				controller = createController();
				expect(controller.crossingDetails.meta).to.be.equal(undefined);
			});

			it('should be not undefined after running', function() {
				controller = createController();
				controller.markerClicked(null, null, { id: 12345 });
				$httpBackend.flush();
				expect(controller.crossingDetails.meta).to.not.be.equal(undefined);
			});
		});

	});


	describe('ctrl.closeCrossingDetals()', function() {

		it('should set showCrossingDetails to false', function () {
			controller = createController();
			controller.showCrossingDetails = true;
			controller.closeCrossingDetals();
			expect(controller.showCrossingDetails).to.be.equal(false);
		});

		it('should set crossingDetails to an empty object', function () {
			controller = createController();
			controller.crossingDetails = {a:123};
			controller.closeCrossingDetals();
			expect(controller.crossingDetails).to.deep.equal({});
		});

	});


	// Test that all of the parameters of the function are still valid
	afterEach(function() {
		expect(controller.zoom).to.be.within(0,20);
		expect(controller.center.latitude).to.be.within(-180,180);
		expect(controller.center.longitude).to.be.within(-180,180);
		expect(controller.gateMarkers).to.be.instanceof(Array);
		
		expect(controller.showCrossingDetails).to.be.a('boolean');
		expect(controller.crossingDetails).to.be.instanceof(Object);

		expect(controller.googleMap).to.be.instanceof(Object);
	});

	afterEach(function() {
		$httpBackend.verifyNoOutstandingExpectation();
		$httpBackend.verifyNoOutstandingRequest();
	});
});
